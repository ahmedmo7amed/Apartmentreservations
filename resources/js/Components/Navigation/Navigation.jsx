import React from 'react';
export default function Navigation() {
    const sections = [
        { id: 'overview', label: 'Overview' },
        { id: 'features', label: 'Features' },
        { id: 'host', label: 'Host' },
        { id: 'reviews', label: 'Reviews' },
    ];

    return (
        <div className="rbt-inner-onepage-navigation sticky-top mt--30">
            <nav className="mainmenu-nav onepagenav">
                <ul className="mainmenu">
                    {sections.map((section, index) => (
                        <li key={section.id} className={index === 0 ? 'current' : ''}>
                            <a href={`#${section.id}`}>{section.label}</a>
                        </li>
                    ))}
                </ul>
            </nav>
        </div>
    );
}

