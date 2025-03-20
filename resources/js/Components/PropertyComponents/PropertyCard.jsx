import { Link } from "@inertiajs/react";
import { StarIcon } from "@heroicons/react/24/solid";

export default function PropertyCard({ property }) {
    return (
        <div className="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl transition-shadow duration-300">
            {/* صورة العقار */}
            <img
                src={property.image || "/default-property.jpg"}
                alt={property.title}
                className="w-full h-48 object-cover"
            />

            <div className="p-4">
                {/* اسم العقار */}
                <h3 className="text-lg font-semibold">{property.title}</h3>

                {/* الموقع */}
                <p className="text-sm text-gray-500">{property.location}</p>

                {/* السعر */}
                <p className="text-md font-bold text-indigo-600 mt-2">
                    {property.price} {property.currency} / {property.booking_type}
                </p>

                {/* التقييم */}
                <div className="flex items-center mt-2">
                    {[...Array(5)].map((_, i) => (
                        <StarIcon
                            key={i}
                            className={`h-5 w-5 ${
                                i < property.rating ? "text-yellow-400" : "text-gray-300"
                            }`}
                        />
                    ))}
                    <span className="text-gray-500 text-sm ml-2">
                        {property.rating} / 5
                    </span>
                </div>

                {/* زر التفاصيل */}
                <Link
                    href={`/properties/${property.id}`}
                    className="block text-center bg-indigo-600 text-white py-2 rounded-lg mt-4 hover:bg-indigo-700 transition"
                >
                    عرض التفاصيل
                </Link>
            </div>
        </div>
    );
}
