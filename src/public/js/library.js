document.addEventListener(
    'DOMContentLoaded',
    () => {
        const body = document.body;

        const openMenuButton =
            document.querySelector(
                '[data-open-mobile-menu]'
            );

        const closeMenuButton =
            document.querySelector(
                '[data-close-mobile-menu]'
            );

        const mobileMenu =
            document.querySelector(
                '[data-mobile-menu]'
            );

        const menuBackdrop =
            document.querySelector(
                '[data-menu-backdrop]'
            );

        const setMobileMenu = (open) => {
            mobileMenu?.classList.toggle(
                'is-open',
                open
            );

            menuBackdrop?.classList.toggle(
                'is-open',
                open
            );

            body.classList.toggle(
                'menu-open',
                open
            );

            openMenuButton?.setAttribute(
                'aria-expanded',
                String(open)
            );
        };

        openMenuButton?.addEventListener(
            'click',
            () => setMobileMenu(true)
        );

        closeMenuButton?.addEventListener(
            'click',
            () => setMobileMenu(false)
        );

        menuBackdrop?.addEventListener(
            'click',
            () => setMobileMenu(false)
        );

        const openFilterButton =
            document.querySelector(
                '[data-open-filter]'
            );

        const closeFilterButton =
            document.querySelector(
                '[data-close-filter]'
            );

        const filterDrawer =
            document.querySelector(
                '[data-filter-drawer]'
            );

        const filterBackdrop =
            document.querySelector(
                '[data-filter-backdrop]'
            );

        const setFilterDrawer = (open) => {
            filterDrawer?.classList.toggle(
                'is-open',
                open
            );

            filterBackdrop?.classList.toggle(
                'is-open',
                open
            );

            body.classList.toggle(
                'menu-open',
                open
            );
        };

        openFilterButton?.addEventListener(
            'click',
            () => setFilterDrawer(true)
        );

        closeFilterButton?.addEventListener(
            'click',
            () => setFilterDrawer(false)
        );

        filterBackdrop?.addEventListener(
            'click',
            () => setFilterDrawer(false)
        );

        document.addEventListener(
            'keydown',
            (event) => {
                if (event.key === 'Escape') {
                    setMobileMenu(false);
                    setFilterDrawer(false);
                }
            }
        );
    }
);
