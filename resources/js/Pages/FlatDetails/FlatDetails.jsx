import React from 'react';
import Swiper from 'swiper';
import FlatImage from "@/Components/FlatImage/FlatImage.jsx";
import Navigation from "@/Components/Navigation/Navigation.jsx";
import Overview from "@/Components/OverView/OverView.jsx";
import Features from "@/Components/Feature/Features.jsx";
import Host from "@/Components/Host/Host.jsx";
import Reviews from "@/Components/Reviews/Reviews.jsx";
import RelatedFlats from "@/Components/RelatedFlats/RelatedFlats.jsx";
import {Sidebar} from "flowbite-react";

export default function FlatDetails( { flat } ) {
    return (
        <div className="flat-details-area ptb--60">
            <div className="container">
                <div className="row g-5">
                    <div className="col-lg-8">
                        <div className="flat-details-content">
                            <FlatImage image={flat.images[0]} />
                            <Navigation />
                            <Overview flat={flat} />
                            <Features flat={flat} />
                            <Host />
                            <Reviews />
                            <RelatedFlats />
                        </div>
                    </div>
                    <div className="col-lg-4">
                        <Sidebar flat={flat} />
                    </div>
                </div>
            </div>
        </div>
    );
}

