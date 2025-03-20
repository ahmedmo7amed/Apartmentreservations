import { Link } from "@inertiajs/react";
import { StarIcon } from "@heroicons/react/24/solid";
import {Bars3Icon, XMarkIcon} from "@heroicons/react/24/outline/index.js";
import {Dialog, DialogPanel} from "@headlessui/react";
import {Component} from "react";
import SearchForm from "@/Components/SearchForm/SearchForm.jsx";


export default function  Herosection({properties}) {


        return (

            <>
                <div className="container-fluid rbt-breadcrumb-default rbt-breadcrumb-style-3">
                    <div className="breadcrumb-inner">
                        <img src="/storage/assets/images/bg/bg-image-10.jpg" alt="Education Images"/>

                    </div>
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-8">
                                <div className="content text-start">
                                    <ul className="page-list">
                                        <li className="rbt-breadcrumb-item"><a href="/"> الرئيسية </a></li>
                                        <li>
                                            <div className="icon-right"><i className="feather-chevron-right"></i></div>
                                        </li>
                                        <li className="rbt-breadcrumb-item active"> فنادق المملكة </li>
                                    </ul>
                                    <h2 className="title"> احجز أفضل الفنادق بأفضل الأسعار! </h2>
                                    <p className="description"> 
                                        استمتع بإقامة فاخرة بأفضل الأسعار! احجز فندقك الآن بسهولة وأمان."
                                    <br/>
                                     اختر وجهتك، حدد تاريخ سفرك، واستكشف أفضل العروض! 
                                     </p>

                                    <div
                                        className="d-flex align-items-center mb--20 flex-wrap rbt-course-details-feature">

                                        <div className="feature-sin best-seller-badge">
                                <span className="rbt-badge-2">
                                    <span className="image"><img src="storage/assets/images/icons/card-icon-1.png"
                                                                 alt="Best Seller Icon"/></span> أفضل العروض
                                </span>
                                        </div>

                                        <div className="feature-sin rating">
                                            <a href="#">4.8</a>
                                            <a href="#"><i className="fa fa-star"></i></a>
                                            <a href="#"><i className="fa fa-star"></i></a>
                                            <a href="#"><i className="fa fa-star"></i></a>
                                            <a href="#"><i className="fa fa-star"></i></a>
                                            <a href="#"><i className="fa fa-star"></i></a>
                                        </div>

                                        <div className="feature-sin total-rating">
                                            <a className="rbt-badge-4" href="#">215,475 زائر </a>
                                        </div>

                                        <div className="feature-sin total-student">
                                            <span>616  غرفة </span>
                                        </div>

                                    </div>

                                    <div className="rbt-author-meta mb--20">
                                        <div className="rbt-avater">
                                            <a href="#">
                                                <img src="storage/assets/images/client/avatar-02.png" alt="Sophia Jaymes"/>
                                            </a>
                                        </div>
                                        <div className="rbt-author-info">
                                             أسكن  <a href="profile.html"> بأطهر </a> بقاع  <a href="#"> المملكة </a>
                                        </div>
                                    </div>

                                    <ul className="rbt-meta">
                                        <li><i className="feather-calendar"></i>  نظافة دورية / تجديد مستمر</li>
                                        <li><i className="feather-globe"></i> المملكة العربية السعودية </li>
                                        <li><i className="feather-award"></i> المدينة النبوية / مكة المكرمة </li>
                                    </ul>
                                </div>

                            </div>


                        </div>
                    </div>
                    <SearchForm />
                </div>


            </>


        );
}
