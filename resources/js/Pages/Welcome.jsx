import React, {useState} from "react";

import { Fragment } from 'react';
import Flats from "@/Pages/Flats/Flats.jsx";
import Header from "@/Components/Header/Header.jsx";
import Herosection from "@/Components/HeroSection/Herosection.jsx";
import BannerSection from "@/Components/BannerSection/BannerSection.jsx";
import AboutUs from "@/Components/AboutUs/AboutUs.jsx";
import Footer from "@/Components/Footer/Footer.jsx";
import SideBar from "@/Components/SideBar/SideBar.jsx";
import FlatDetails from "@/Pages/FlatsDetails/FlatsDetails.jsx";
import ErrorBoundary from "@/Pages/ErrorBoundary.jsx";
import {Link} from "@inertiajs/react";
import BookPage from "@/Components/BookPage/BookPage.jsx";
import {BrowserRouter, Route} from "react-router-dom";
import Routes from "@/routes.js";

export default function Welcome({ auth, laravelVersion, phpVersion, flats }) {



    const handleImageError = () => {
        document
            .getElementById('screenshot-container')
            ?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document
            .getElementById('docs-card-content')
            ?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };

    const [mobileMenuOpen, setMobileMenuOpen] = useState(false)

    const testFlats = [
        {
            id: 1,
            title: "Flat 1",
            bedrooms: 2,
            floor_area: 1200,
            bathrooms: 2,
            description: "A beautiful flat in the city center.",
            address: "123 Main St",
            status: "Available",
            price: 1500,
            images: ["/path/to/image1.jpg"],
        },
        // بيانات إضافية
    ];

    return (

        <ErrorBoundary>
            <Fragment>
                <div className="container-fluid p-4" dir="rtl">
                    <Header />
                    <Herosection />
                    <Link href="/flats" className="btn btn-primary mb-4">
                        عرض جميع الشقق
                    </Link>
                    {/*{flats.length > 0 && <FlatDetails flats={flats[0]} />}*/}
                </div>
                <Flats flats={flats} />
                <div className="mt-8">
                    <AboutUs />
                </div>
                <div className="mt-8">

                    <Footer />
                </div>
            </Fragment>
        </ErrorBoundary>

    );
}
