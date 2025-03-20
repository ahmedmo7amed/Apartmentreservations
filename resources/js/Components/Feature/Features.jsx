import React from 'react';
export default function Features({ flat = { features: []} }) {

    if (!flat || !Array.isArray(flat.features)) {
        return <div>No features available</div>;
    }

    return (
        <div className="flat-content rbt-shadow-box features-wrapper mt--30" id="features">
            <div className="rbt-flat-feature-inner">
                <div className="section-title">
                    <h4 className="rbt-title-style-3">Flat Features</h4>
                </div>
                {flat.features.length > 0 ? (
                <div className="row g-5">
                    <div className="col-lg-6">
                        <ul className="rbt-list-style-1">
                            {flat.features.slice(0, Math.ceil(flat.features.length / 2)).map((feature, index) => (
                                <li key={index}>
                                    <i className="feather-check"></i> {feature.name}: {feature.value}
                                </li>
                            ))}
                        </ul>
                    </div>
                    <div className="col-lg-6">
                        <ul className="rbt-list-style-1">
                            {flat.features.slice(Math.ceil(flat.features.length / 2)).map((feature, index) => (
                                <li key={index}>
                                    <i className="feather-check"></i> {feature.name}: {feature.value}
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>
                ) : (
                    <p>No features available</p>
                )}
            </div>
        </div>
    );
}
