import React from 'react';
export default function Reviews() {
    const reviews = [
        { id: 1, name: 'Jane Smith', rating: 5, text: 'Amazing stay!' },
        { id: 2, name: 'Mike Johnson', rating: 4, text: 'Great location' },
    ];

    return (
        <div className="rbt-reviews-wrapper rbt-shadow-box mt--30" id="reviews">
            <div className="section-title">
                <h4 className="rbt-title-style-3">Reviews</h4>
            </div>
            {reviews.map(review => (
                <div key={review.id} className="rbt-review">
                    <div className="media">
                        <div className="media-body">
                            <h5 className="title">{review.name}</h5>
                            <div className="rating">
                                {[...Array(review.rating)].map((_, i) => (
                                    <i key={i} className="fa fa-star"></i>
                                ))}
                            </div>
                            <p>{review.text}</p>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
}
