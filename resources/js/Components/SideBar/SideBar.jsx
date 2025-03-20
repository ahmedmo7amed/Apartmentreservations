import React, { useState } from 'react';
import { Link } from "@inertiajs/react";

export default function Sidebar({ flat = { features: [] }, hasConfirmedBooking }) {
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');

    const handleBookNow = () => {
        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        if (new Date(endDate) <= new Date(startDate)) {
            alert('End date must be after start date.');
            return;
        }
        console.log(startDate);
        // توجيه المستخدم إلى صفحة الحجز
        window.location.href = `/bookings/${flat.id}?start_date=${startDate}&end_date=${endDate}`;
    };

    const features = Array.isArray(flat.features) ? flat.features : [
        { name: 'Bedrooms', value: '2' },
        { name: 'Bathrooms', value: '2' },
        { name: 'Area', value: '200 sqft' },
    ];

    const isBooked = Array.isArray(flat.bookings) && flat.bookings.some(booking => booking.status === "confirmed");

    return (
        <div className="flat-sidebar sticky-top rbt-shadow-box">
            <div className="inner">
                <div className="rbt-price-wrapper">
                    <div className="rbt-price">
                        <span className="current-price">${flat.price}</span>
                        <span className="off-price">${flat.originalPrice}</span>
                    </div>
                </div>

                {/* حقول إدخال لتحديد تاريخ البدء والانتهاء */}
                <div className="flex space-x-4 mt-4">
                    <div className="flex-1">
                        <label htmlFor="start_date" className="block text-sm font-medium text-gray-700">
                            Start Date
                        </label>
                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value={startDate}
                            onChange={(e) => setStartDate(e.target.value)}
                        />
                    </div>
                    <div className="flex-1">
                        <label htmlFor="end_date" className="block text-sm font-medium text-gray-700">
                            End Date
                        </label>
                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value={endDate}
                            onChange={(e) => setEndDate(e.target.value)}
                        />
                    </div>
                </div>

                {/* زر "Book Now" مع إضافة تواريخ البدء والانتهاء إلى الرابط */}
                <div className="add-to-cart-button mt-4">
                    <Link
                        className={`rbt-btn w-100 ${hasConfirmedBooking ? "btn-secondary" : "btn-gradient"}`}
                        href={hasConfirmedBooking ? "#" : route('bookings.show', { id: flat.id, start_date: startDate, end_date: endDate })}
                    >
                        {hasConfirmedBooking ? "Booked" : "Book Now"}
                    </Link>
                </div>

                {/* قائمة الميزات */}
                <div className="rbt-widget-details mt-4">
                    <ul className="rbt-course-details-list-wrapper">
                        {features.map((feature, index) => (
                            <li key={index}>
                                <span>{feature.name}</span>
                                <span className="rbt-feature-value">{feature.value}</span>
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
        </div>
    );
}
