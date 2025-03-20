import React, { useState } from 'react';

const SearchForm = () => {
    const [search, setSearch] = useState('');
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [propertyType, setPropertyType] = useState('room'); // room or flat
    const [guests, setGuests] = useState(1);

    const handleToggle = (e) => {
        // عند تفعيل المفتاح يتم تحديد الشقة وإلا الغرفة
        setPropertyType(e.target.checked ? 'flat' : 'room');
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        // Send data to the '/search' route using Inertia
        Inertia.get('/search', {
            search,
            startDate,
            endDate,
            propertyType,
            guests,
        });
        // هنا يمكنك التعامل مع البيانات كما تشاء، مثلاً إرسالها إلى API
        console.log({ search, startDate, endDate, propertyType, guests });
    };

    return (

        <div className="rbt-course-details-area ptb--60 mt-9">
            <div className="container">
                <div className="row g-5">
                    <div className="col-lg-12 mt-5">
                        <div
                            className="course-sidebar sticky-top rbt-shadow-box  rbt-gradient-border">
                            <div className="inner">
                                {/* العنوان */}
                                <h4 className="rbt-title-style-3 mb--20">أدخل تفاصيل الحجز </h4>

                                {/* النموذج */}
                                <form onSubmit={handleSubmit} className="space-y-6">

                                    {/* حقل البحث */}
                                    <div className="relative">
                                        <input
                                            type="text"
                                            name="search"
                                            id="search"
                                            placeholder="Search for properties"
                                            className="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-blue-500"
                                            value={search}
                                            onChange={(e) => setSearch(e.target.value)}
                                        />
                                    </div>

                                    {/* حقول اختيار التاريخ */}
                                    <div className="flex space-x-4">
                                        <div className="flex-1">
                                            <label htmlFor="start_date"
                                                   className="block text-sm font-medium text-gray-700"> من تاريخ </label>
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
                                            <label htmlFor="end_date"
                                                   className="block text-sm font-medium text-gray-700"> الي تاريخ </label>
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

                                    {/* مفتاح التبديل لاختيار نوع الملكية */}
                                    <div className="flex items-center justify-between">
                                        <div className="flex items-center">
                                            <span className="mr-2 text-sm text-gray-700 p-2"> غرفة </span>
                                            <label className="relative inline-flex items-center cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    name="property_type"
                                                    id="property_type"
                                                    className="sr-only peer"
                                                    checked={propertyType === 'flat'}
                                                    onChange={handleToggle}
                                                />
                                                <div
                                                    className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full dark:bg-gray-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-500"></div>
                                            </label>
                                            <span className="ml-2 text-sm text-gray-700 p-2"> شقة </span>
                                        </div>

                                        {/* عدد الضيوف */}
                                        <div>
                                            <label htmlFor="guests"
                                                   className="block text-sm font-medium text-gray-700"> ضيوف </label>
                                            <input
                                                type="number"
                                                name="guests"
                                                id="guests"
                                                min="1"
                                                placeholder="Number of Guests"
                                                className="mt-1 block w-24 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                value={guests}
                                                onChange={(e) => setGuests(e.target.value)}
                                            />
                                        </div>
                                    </div>

                                    {/* زر البحث */}
                                    <div>
                                        <button
                                            onClick={() => handleSubmit()}
                                            type="submit"
                                            className="w-full flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                            بحث
                                        </button>
                                    </div>
                                </form>
                                {/* مشاركة عبر وسائل التواصل الاجتماعي */}
                                <div className="social-share-wrapper mt--30 text-center">
                                    <div className="rbt-post-share d-flex align-items-center justify-content-center">
                                        <ul className="social-icon social-default transparent-with-border justify-content-center">
                                            <li>
                                                <a href="https://www.facebook.com/">
                                                    <i className="feather-facebook"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.twitter.com">
                                                    <i className="feather-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.instagram.com/">
                                                    <i className="feather-instagram"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.linkdin.com/">
                                                    <i className="feather-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr className="mt--20"/>
                                    <div className="contact-with-us text-center">
                                        <p>For details about the booking</p>
                                        <p className="rbt-badge-2 mt--10 justify-content-center w-100">
                                            <i className="feather-phone mr--5"></i> أتصل بنا:{" "}
                                            <a href="#">
                                                <strong>+444 555 666 777</strong>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    );
};

export default SearchForm;
