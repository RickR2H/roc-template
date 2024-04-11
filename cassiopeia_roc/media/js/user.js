// Add a class if the navbar is sticking to the top of the screen
checkPosition = () => {

    // Create an element to watch
    const containerNav = document.querySelector('.container-header');
    const containerHeight = containerNav.offsetHeight;
    const scrollWatcher = document.createElement('div');

    scrollWatcher.setAttribute('data-scroll-watcher', '');
    containerNav.before(scrollWatcher);

    const navObserver = new IntersectionObserver((entries) => {

        // Add class sticking to element: containerNav
        containerNav.classList.toggle('sticking', !entries[0].isIntersecting);

    },
    // rootmargin: extra margin before element get sticking class
    // Remove rootMargin {rootMargin: (containerHeight + 10) + 'px'});
    {rootMargin: 0 + 'px'});

    navObserver.observe(scrollWatcher);
}

checkDirection = () => {

    // print "false" if direction is down and "true" if up
    let direction = this.oldScroll > this.scrollY;
    if (direction) {
        document.body.classList.add("scrollUp");
        document.body.classList.remove("scrollDown");
    } else {
        document.body.classList.remove("scrollUp");
        document.body.classList.add("scrollDown");
    }

    this.oldScroll = this.scrollY;
}

document.addEventListener('DOMContentLoaded', function() {
    checkPosition();

    // Monitor scroll directions
    window.addEventListener("scroll", () => {
        checkDirection();
    });
})
