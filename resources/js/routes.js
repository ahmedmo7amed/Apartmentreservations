import BookPage from '@/Pages/BookPage';

const routes = [
    // {
    //     path: '/book/:flat',
    //     component: BookPage,
    //     name: 'book.show',
    // },
    {
        path:'/bookings/:id',
        component: BookPage,
        name: 'bookings.show',
    }
];

export default routes;
