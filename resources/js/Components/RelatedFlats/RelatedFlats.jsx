import React from 'react';

export default function RelatedFlats({ flatId, flat, relatedFlats = [] }) {
    if (!relatedFlats || relatedFlats.length === 0) {
        return (
            <div className="related-flats mt--60">
                <div className="section-title">
                    <h4 className="title">No related flats available</h4>
                </div>
            </div>
        );
    }

    return (
        <div className="related-flats mt--60">
            <div className="section-title">
                <h4 className="title">Related Flats</h4>
            </div>
            <div className="row g-5">
                {relatedFlats.map(flat => (
                    <div key={flat.id} className="col-lg-6">
                        <div className="rbt-card">
                            <div className="rbt-card-img">
                                <img src={flat.images[0]} alt={flat.title} />
                            </div>
                            <div className="rbt-card-body">
                                <h4 className="rbt-card-title">{flat.title}</h4>
                                <div className="rbt-price">${flat.price}/night</div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
