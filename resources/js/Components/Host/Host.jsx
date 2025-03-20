import React from 'react';

export default function Host() {
    const host = {
        name: 'John Doe',
        image: 'assets/images/host/host-01.jpg',
        rating: 4.8,
        reviews: 152,
        guests: 987,
    };

    return (
        <div className="rbt-host rbt-shadow-box host-wrapper mt--30" id="host">
            <div className="about-host">
                <div className="section-title mb--30">
                    <h4 className="rbt-title-style-3">Host</h4>
                </div>
                <div className="media align-items-center">
                    <div className="thumbnail">
                        <a href="#">
                            <img src={host.image} alt="Host" />
                        </a>
                    </div>
                    <div className="media-body">
                        <h5 className="title">{host.name}</h5>
                        <span className="b3 subtitle">Super Host</span>
                        <ul className="rbt-meta mb--20 mt--10">
                            <li>
                                <i className="fa fa-star color-warning"></i>{host.reviews} Reviews
                                <span className="rbt-badge-5 ml--5">{host.rating} Rating</span>
                            </li>
                            <li><i className="feather-users"></i>{host.guests} Guests</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
}
