import React from 'react';

export default function FlatImage({ image }) {
    return (
        <div className="flat-feature-box rbt-shadow-box thumbnail">
            <img className="w-100" src={"../storage/" + image} alt="Flat image" />
        </div>
    );
}
