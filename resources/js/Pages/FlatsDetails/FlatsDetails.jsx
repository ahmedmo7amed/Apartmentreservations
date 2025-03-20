import React from 'react';
import FlatImage from "@/Components/FlatImage/FlatImage.jsx";
import Navigation from "@/Components/Navigation/Navigation.jsx";
import Overview from "@/Components/OverView/OverView.jsx";
import Features from "@/Components/Feature/Features.jsx";
import Host from "@/Components/Host/Host.jsx";
import Reviews from "@/Components/Reviews/Reviews.jsx";
import RelatedFlats from "@/Components/RelatedFlats/RelatedFlats.jsx";
import SideBar from "@/Components/SideBar/SideBar.jsx";
import 'swiper/swiper-bundle.css';
import Header from "@/Components/Header/Header.jsx";
import Herosection from "@/Components/HeroSection/Herosection.jsx";
import {Link} from "@inertiajs/react";


function FlatDetails({ flat , relatedFlats , hasConfirmedBooking}) {

    if (!flat) {
        return <div>Loading...</div>;
    }

    const flats = flat;
    const features = flat.features || [];

    return (
        <>
            <div className="container-fluid p-4" dir="rtl">
                <Header/>
                <Herosection />
                <Link href="/flats" className="btn btn-primary mb-4">
                    عرض جميع الشقق
                </Link>
                {/*{flats.length > 0 && <FlatDetails flats={flats[0]} />}*/}
            </div>
            <div className="flat-details-area ptb--60">
                <div className="container">
                    <div className="row g-5">
                        <div className="col-lg-8">
                            <div className="flat-details-content">
                                <FlatImage image={flat.images[0]}/>
                                <Navigation/>
                                <Overview flat={flat}/>
                                <Features flat={flat}/>
                                <Host/>
                                <Reviews/>
                                <RelatedFlats flatId={flat.id} flat={flat} relatedFlats={relatedFlats} />
                            </div>
                        </div>
                        <div className="col-lg-4">
                            <SideBar flat={flat} hasConfirmedBooking={hasConfirmedBooking}/>
                        </div>
                    </div>
                </div>
            </div>
            </>
            );
            }

            export default FlatDetails;
