import React, { useState, useEffect } from "react";
import { usePage, router } from "@inertiajs/react";
import axios from "axios";

export default function BookPage() {
    const { props } = usePage();
    const flat = props.flat;
    const authUser = props.auth?.user;

    // الحالة المحلية
    const [startDate, setStartDate] = useState(props.start_date || "");
    const [endDate, setEndDate] = useState(props.end_date || "");
    const [error, setError] = useState("");
    const [isLoading, setIsLoading] = useState(false);
    const [bookingDetails, setBookingDetails] = useState(null);
    const [isAvailable, setIsAvailable] = useState(null);
    const [bookingSuccess, setBookingSuccess] = useState("");

    // التحقق من وجود الشقة
    if (!flat) return <p className="text-center text-red-500">الشقة غير موجودة</p>;

    // التحقق من صحة التواريخ
    const validateDates = () => {
        if (!startDate || !endDate) {
            setError("يرجى اختيار تاريخ البداية والنهاية.");
            return false;
        }
        if (new Date(endDate) <= new Date(startDate)) {
            setError("تاريخ النهاية يجب أن يكون بعد تاريخ البداية.");
            return false;
        }
        return true;
    };

    // حساب عدد الأيام
    const calculateDays = (start, end) => {
        const startDate = new Date(start);
        const endDate = new Date(end);
        const hours = (endDate - startDate) / (1000 * 60 * 60);
        return Math.max(1, Math.ceil(hours / 24));
    };

    // تحميل بيانات الحجز عند التحميل الأولي
    useEffect(() => {
        const loadBookingDetails = async () => {
            try {
                const response = await axios.get(`/bookings/${flat.id}/details`, {
                    params: {
                        user_id: authUser?.id || null
                    }
                });

                if (response.data.booking) {
                    setBookingDetails(response.data.booking);
                }
            } catch (error) {
                console.error("Error loading booking details:", error);
            }
        };

        loadBookingDetails();
    }, [flat.id, authUser?.id]);

    // التحقق من توفر الشقة
    useEffect(() => {
        if (!validateDates()) return;

        const checkAvailability = async () => {
            try {
                const response = await axios.get(`/check-availability`, {
                    params: {
                        bookable_type: "App\\Models\\Flat",
                        bookable_id: flat.id,
                        time_from: startDate,
                        time_to: endDate,
                        user_id: authUser?.id || null
                    }
                });

                const { available, booking } = response.data;
                setIsAvailable(available);

                if (!available) {
                    if (booking && booking.user_id === authUser?.id) {
                        setBookingDetails(booking);
                        setError("");
                    } else {
                        setBookingDetails(null);
                        setError("الشقة غير متوفرة حاليًا في التواريخ المختارة.");
                    }
                } else {
                    setBookingDetails(null);
                    setError("");
                }
            } catch (error) {
                console.error("Check Availability Error:", error.response?.data || error.message);
                setIsAvailable(false);
                setBookingDetails(null);
                setError("خطأ في التحقق من التوفر: " + (error.response?.data?.message || error.message));
            }
        };

        checkAvailability();
    }, [startDate, endDate, flat.id, authUser?.id]);

    // حجز الشقة
    const handleBookNow = async () => {
        if (!validateDates() || !isAvailable) return;

        if (!authUser) {
            setError("يرجى تسجيل الدخول لحجز الشقة.");
            setTimeout(() => {
                router.visit('/login');
            }, 1000);
            return;
        }

        setIsLoading(true);
        setError("");

        try {
            const days = calculateDays(startDate, endDate);
            const totalPrice = flat.price * days;

            const response = await axios.post(`/bookings/book/${flat.id}`, {
                time_from: startDate,
                time_to: endDate,
                additional_information: null,
                total_price: totalPrice,
                booking_type: "daily",
                type: "flat",
                id: flat.id,
                user_id: authUser?.id || null
            });

            // تحديث حالة الصفحة ببيانات الحجز
            setBookingDetails(response.data.booking);
            setBookingSuccess("تم الحجز بنجاح!");
            setStartDate("");
            setEndDate("");
            setIsAvailable(null);
            setError("");
        } catch (error) {
            console.error("Error booking the flat:", error.response?.data || error.message);
            const errorMessage = error.response?.data?.message || "فشل في حجز الشقة. حاول مرة أخرى لاحقًا.";
            setError(errorMessage);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <div className="container mx-auto p-4">
            <h1 className="text-2xl font-bold mb-4">حجز الشقة: {flat.title}</h1>

            <div className="bg-white shadow-md rounded-lg p-4 mb-4">
                <h2 className="text-xl font-semibold mb-2">{flat.title}</h2>
                <p className="text-gray-700">{flat.description}</p>
                <p className="text-gray-700">السعر: ${flat.price} لليلة</p>
                {startDate && endDate && (
                    <p className="text-gray-700">
                        السعر الإجمالي: ${flat.price * calculateDays(startDate, endDate)}
                    </p>
                )}
            </div>

            <div className="bg-white shadow-md rounded-lg p-4 mb-4">
                <div className="flex space-x-4">
                    <div className="flex-1">
                        <label htmlFor="start_date" className="block text-sm font-medium text-gray-700">
                            تاريخ البداية
                        </label>
                        <input
                            type="date"
                            id="start_date"
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value={startDate}
                            onChange={(e) => setStartDate(e.target.value)}
                            required
                        />
                    </div>
                    <div className="flex-1">
                        <label htmlFor="end_date" className="block text-sm font-medium text-gray-700">
                            تاريخ النهاية
                        </label>
                        <input
                            type="date"
                            id="end_date"
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value={endDate}
                            onChange={(e) => setEndDate(e.target.value)}
                            required
                        />
                    </div>
                </div>

                {error && <p className="text-red-500 mt-2">{error}</p>}
                {bookingDetails && (
                    <div className="mt-4 p-4 bg-gray-100 rounded-lg">
                        <h3 className="text-lg font-semibold">بيانات حجزك</h3>
                        <p>من: {bookingDetails.time_from}</p>
                        <p>إلى: {bookingDetails.time_to}</p>
                        <p>الحالة: {bookingDetails.status}</p>
                        <p>السعر الإجمالي: ${bookingDetails.total_price}</p>
                    </div>
                )}
                {isAvailable && !bookingDetails && (
                    <p className="text-green-500 mt-2">الشقة متاحة للحجز!</p>
                )}
            </div>

            {!bookingDetails && (
                <div className="text-center">
                    <button
                        onClick={handleBookNow}
                        disabled={isLoading || !isAvailable}
                        className={`bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 ${
                            (isLoading || !isAvailable) ? 'opacity-50 cursor-not-allowed' : ''
                        }`}
                    >
                        {isLoading ? 'جارٍ الحجز...' : 'تأكيد الحجز'}
                    </button>
                </div>
            )}
        </div>
    );
}
