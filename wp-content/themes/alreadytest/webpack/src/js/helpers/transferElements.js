function transferElement(elem, media, newPosition, where) {
    let oldParent = elem.parentElement;
    let oldPosition = [...oldParent.children].indexOf(elem);
    let newParent = document.querySelector(newPosition)

    const mediaQuery = window.matchMedia(media)

    function handleTabletChange(e) {
        if (e.matches) {
            newParent.insertAdjacentElement(where, elem);
        } else {
            if (oldParent.children[oldPosition] !== undefined) {
                oldParent.children[oldPosition].before(elem);
            } else {
                oldParent.append(elem);
            }
        }
    }



    try {
        // Chrome & Firefox
        mediaQuery.addEventListener('change', handleTabletChange)
    } catch (e1) {
        try {
            // Safari
            mediaQuery.addListener('change', handleTabletChange)
        } catch (e2) {
            console.error(e2);
        }
    }
    handleTabletChange(mediaQuery)
}


export default transferElement
