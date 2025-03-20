import { Carousel } from "flowbite-react";

export default function  CarouselCard ({flats= []}) {
    if (!flats || flats.length === 0) {
        return <p>No flats available.</p>;  // رسالة توضح أن البيانات غير متوفرة
    }
    return (
        <div className="grid h-56 grid-cols-2 gap-4 sm:h-64 xl:h-80 2xl:h-96">
            {flats.map((flat) => (
                <Carousel key={flat.id} indicators={false}>
                    {flat.images?.map((image, index) => (
                        <a key={index} href={`/flats/${flat.id}`}>
                            <img src={`/storage/${image}`} alt={`Flat ${flat.id}`} />
                        </a>
                    ))|| <p>No images available</p>}
                </Carousel>
            ))}

        </div>
    );
}
