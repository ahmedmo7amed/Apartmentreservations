import React, { useEffect } from 'react';
import { Link } from "@inertiajs/react";
import { useLocation } from "react-router-dom";

const Flats = ({ flats , isWelcomePage}) => {

    useEffect(() => {
        if (!isWelcomePage) {
            import("@/pages/Flats/assets/css/vendor/bootstrap.min.css");
            import("@/pages/Flats/assets/css/vendor/slick.css");
            import("@/pages/Flats/assets/css/vendor/slick-theme.css");
            import("@/pages/Flats/assets/css/plugins/sal.css");
            import("@/pages/Flats/assets/css/plugins/feather.css");
            import("@/pages/Flats/assets/css/plugins/fontawesome.min.css");
            import("@/pages/Flats/assets/css/plugins/euclid-circulara.css");
            import("@/pages/Flats/assets/css/plugins/swiper.css");
            import("@/pages/Flats/assets/css/plugins/magnify.css");
            import("@/pages/Flats/assets/css/plugins/odometer.css");
            import("@/pages/Flats/assets/css/plugins/animation.css");
            import("@/pages/Flats/assets/css/plugins/bootstrap-select.min.css");
            import("@/pages/Flats/assets/css/plugins/jquery-ui.css");
            import("@/pages/Flats/assets/css/plugins/magnigy-popup.min.css");
            import("@/pages/Flats/assets/css/plugins/plyr.css");
            import("@/pages/Flats/assets/css/style.css");
        }
    }, [isWelcomePage]);

    return (


        <div className="rbt-course-area bg-color-white rbt-section-gapTop masonary-wrapper-activation">
            <div className="container">
                <div className="row mb--60">
                    <div className="col-lg-12">
                        <div className="section-title text-center">
                            <span className="subtitle bg-primary-opacity"> كل الشقق </span>
                            <h2 className="title"> أختر ما يناسبك من العروض المتوفرة <br/> تجد الأفضل دائما </h2>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-lg-12">
                        <ul className="rbt-portfolio-filter filter-tab-button text-center nav nav-tabs"
                            id="rbt-myTab"
                            role="tablist">
                            <li className="nav-item" role="presentation">
                                <button className="active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                                        type="button" role="tab" aria-controls="all" aria-selected="true"><span
                                    className="filter-text"> جميع الشقق </span> <span className="course-number">06</span></button>
                            </li>
                            <li className="nav-item" role="presentation">
                                <button id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured"
                                        type="button"
                                        role="tab" aria-controls="featured" aria-selected="false"><span
                                    className="filter-text"> العروض المميزة </span> <span
                                    className="course-number">02</span>
                                </button>
                            </li>
                            <li className="nav-item" role="presentation">
                                <button id="popular-tab" data-bs-toggle="tab" data-bs-target="#popular"
                                        type="button"
                                        role="tab" aria-controls="popular" aria-selected="false"><span
                                    className="filter-text"> الأكثر شهرة </span> <span className="course-number">05</span>
                                </button>
                            </li>
                            <li className="nav-item" role="presentation">
                                <button id="trending-tab" data-bs-toggle="tab" data-bs-target="#trending"
                                        type="button"
                                        role="tab" aria-controls="trending" aria-selected="false"><span
                                    className="filter-text"> الرائجة </span> <span
                                    className="course-number">03</span>
                                </button>
                            </li>
                            <li className="nav-item" role="presentation">
                                <button id="latest-tab" data-bs-toggle="tab" data-bs-target="#latest" type="button"
                                        role="tab" aria-controls="latest" aria-selected="false"><span
                                    className="filter-text"> الأحدث </span> <span className="course-number">04</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>


                <div className="row">
                    <div className="col-lg-12">
                        <div className="tab-content mt--60" id="rbt-myTabContent">
                            <div className="tab-pane fade show active" id="all" role="tabpanel"
                                 aria-labelledby="all-tab">
                                <div className="row g-5">
                                    {flats.map((flat) => (
                                    <div className="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div className="rbt-card variation-01 rbt-hover card-list-2">
                                          <div className="col-lg-6">
                                            <div className="rbt-card-img">
                                                <a href={"flats/" +flat.id}>
                                                    <img src={"storage/"+flat.images[0]}
                                                         alt="Card image"/>
                                                </a>
                                            </div>
                                          </div>
                                            <div className="col-lg-6">
                                                <div className="rbt-card-body">
                                                <div className="rbt-card-top">
                                                    <div className="rbt-review">
                                                        <div className="rating">
                                                            <i className="fas fa-star"></i>
                                                            <i className="fas fa-star"></i>
                                                            <i className="fas fa-star"></i>
                                                            <i className="fas fa-star"></i>
                                                            <i className="fas fa-star"></i>
                                                        </div>
                                                        <span className="rating-count"> (15 Reviews)</span>
                                                    </div>
                                                    <div className="rbt-bookmark-btn">
                                                        <a className="rbt-round-btn" title="Bookmark" href="#"><i
                                                            className="feather-bookmark"></i></a>
                                                    </div>
                                                </div>
                                                <h4 className="rbt-card-title"><a href={"flats/" +flat.id}>
                                                    {flat.title}
                                                </a>
                                                </h4>
                                                <ul className="rbt-meta">
                                                    <li><i className="feather-book"></i>{flat.bedrooms} Bedrooms</li>
                                                    <li><i className="feather-book"></i>{flat.floor_area} Floor Area</li>
                                                    <li><i className="feather-users"></i>{flat.bathrooms} Bathrooms</li>
                                                </ul>
                                         
                                                <p className="rbt-card-text">
                                                    {flat.description}
                                                </p>
                                                <div className="rbt-author-meta mb--10">
                                                    <div className="rbt-avater">
                                                    <a href={"flats/" +flat.id}>
                                                            <img src={flat.images[0]}
                                                                 alt="Sophia Jaymes"/>
                                                        </a>
                                                    </div>
                                                    <div className="rbt-author-info">
                                                        By <a href="profile.html">{flat.address}</a> In <a
                                                        href="#">{flat.status}</a>
                                                    </div>
                                                </div>
                                                <div className="rbt-card-bottom">
                                                    <div className="rbt-price">
                                                        <span className="current-price">${flat.price}</span>
                                                        <span className="off-price">$120</span>
                                                    </div>
                                                    <Link className="rbt-btn-link left-icon"
                                                          to={`/flats/${flat.id}`}><i
                                                        className="feather-shopping-cart"></i> أحجز الأن </Link>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    ))}
                                </div>
                            </div>

                            <div className="tab-pane fade" id="popular" role="tabpanel"
                                 aria-labelledby="popular-tab">


                                <div className="tab-pane fade" id="latest" role="tabpanel" aria-labelledby="latest-tab">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    );
};

export default Flats;
