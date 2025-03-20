
import React, {Fragment} from "react";
import CarouselCard from "@/Components/Carousel/CarouselCard.jsx";


export default function BannerSection({ flats}) {
    return (
        <>

            <div className="rbt-banner-area rbt-banner-8 variation-03 section-bottom-overlay" id="home">
                <div className="banner-overlay-section">
                    <div className="container">
                        <CarouselCard />
                    </div>
                </div>
            </div>
        </>
    );
}
