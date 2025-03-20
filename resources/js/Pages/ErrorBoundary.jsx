import { Component } from 'react';

class ErrorBoundary extends Component {
    state = { hasError: false };

    static getDerivedStateFromError(error) {
        return { hasError: true };
    }

    componentDidCatch(error, info) {
        console.error('تم التقاط الخطأ بواسطة الحدود:', error, info);
    }

    render() {
        if (this.state.hasError) {
            return <h1>حدث خطأ ما. الرجاء المحاولة لاحقًا.</h1>;
        }
        return this.props.children;
    }
}

export default ErrorBoundary;
