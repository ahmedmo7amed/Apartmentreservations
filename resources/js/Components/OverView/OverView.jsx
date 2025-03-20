import React from 'react';
export default function Overview({ flat }) {
    return (
        <div className="rbt-flat-feature-box overview-wrapper rbt-shadow-box mt--30" id="overview">
            <div className="rbt-flat-feature-inner">
                <div className="section-title">
                    <h4 className="rbt-title-style-3">About this Flat</h4>
                </div>
                <p>
                    Experience luxury living in this {flat.title}. Perfectly located in {flat.location},
                    this property offers modern amenities and stunning views. Ideal for both short-term stays and extended vacations.
                </p>
            </div>
        </div>
    );
}
