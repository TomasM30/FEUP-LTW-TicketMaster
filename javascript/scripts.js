function scrollHContainer(scrollAmount,direction,container) {
    if(direction === 'left')
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    else
    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
}


