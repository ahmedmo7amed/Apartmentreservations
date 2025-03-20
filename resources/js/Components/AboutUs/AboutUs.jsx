export default function AboutUs() {
    return (
        <div>
            <div className="rbt-conatct-area bg-gradient-11 rbt-section-gap">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <div className="section-title text-center mb--60">
                                <span className="subtitle bg-secondary-opacity">Contact Us</span>
                                <h2 className="title"> نحن هنــا لخدمتكم ! <br /> لا تتردد في التواصل معنا </h2>
                            </div>
                        </div>
                    </div>
                    <div className="row g-5">
                        <div className="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up"
                             data-sal-delay="150" data-sal-duration="800">
                            <div className="rbt-address">
                                <div className="icon">
                                    <i className="feather-headphones"></i>
                                </div>
                                <div className="inner">
                                    <h4 className="title"> رقم الهاتف للتواصل </h4>
                                    <p><a href="tel:+444555666777">+444 555 666 777</a></p>
                                    <p><a href="tel:+222222222333">+222 222 222 333</a></p>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up"
                             data-sal-delay="200" data-sal-duration="800">
                            <div className="rbt-address">
                                <div className="icon">
                                    <i className="feather-mail"></i>
                                </div>
                                <div className="inner">
                                    <h4 className="title"> بريدنا الألكتروني </h4>
                                    <p><a href="mailto:admin@gmail.com">admin@gmail.com</a></p>
                                    <p><a href="mailto:example@gmail.com">example@gmail.com</a></p>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up"
                             data-sal-delay="250" data-sal-duration="800">
                            <div className="rbt-address">
                                <div className="icon">
                                    <i className="feather-map-pin"></i>
                                </div>
                                <div className="inner">
                                    <h4 className="title"> موقعناالجغرافي </h4>
                                    <p>مكة العزيزية, الشارع الرابع  <br /> الرمز البريدي 54786</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="rbt-contact-address">
                <div className="container">
                    <div className="row g-5">
                        <div className="col-lg-6">
                            <div className="thumbnail">
                                <img className="w-100 radius-6" src="/storage/assets/images/about/contact.jpg"
                                     alt="Contact" />
                            </div>
                        </div>

                        <div className="col-lg-6">
                            <div className="rbt-contact-form contact-form-style-1 max-width-auto">
                                <div className="section-title text-start">
                                    <span className="subtitle bg-primary-opacity"> متاح أفضل السكن </span>
                                </div>
                                <h3 className="title"> تواصل معنا لأي أستفسار </h3>
                                <form id="contact-form" method="POST" action="mail.php"
                                      className="rainbow-dynamic-form max-width-auto">
                                    <div className="form-group">
                                        <input name="contact-name" id="contact-name" type="text" required />
                                        <label> الأسم </label>
                                        <span className="focus-border"></span>
                                    </div>
                                    <div className="form-group">
                                        <input name="contact-email" type="email" required />
                                        <label> الأيميل </label>
                                        <span className="focus-border"></span>
                                    </div>
                                    <div className="form-group">
                                        <input type="text" id="subject" name="subject" required />
                                        <label> العنوان </label>
                                        <span className="focus-border"></span>
                                    </div>
                                    <div className="form-group">
                                        <textarea name="contact-message" id="contact-message" required></textarea>
                                        <label> الرسالة </label>
                                        <span className="focus-border"></span>
                                    </div>
                                    <div className="form-submit-group">
                                        <button name="submit" type="submit" id="submit"
                                                className="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                            <span className="icon-reverse-wrapper">
                                                <span className="btn-text"> أرسل الأن </span>
                                                <span className="btn-icon"><i className="feather-arrow-right"></i></span>
                                                <span className="btn-icon"><i className="feather-arrow-right"></i></span>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="rbt-google-map bg-color-white rbt-section-gapTop">
                <iframe className="w-100"
                        src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2965.0824050173574!2d-93.63905729999999!3d41.998507000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWebFilings%2C+University+Boulevard%2C+Ames%2C+IA!5e0!3m2!1sen!2us!4v1390839289319"
                        height="600" style={{ border: 0 }} allowFullScreen="" loading="lazy"></iframe>
            </div>

            <div className="rbt-progress-parent">
                <svg className="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
                    <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
                </svg>
            </div>
        </div>
    );
}
