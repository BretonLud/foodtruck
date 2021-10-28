window.addEventListener('scroll', () => {
    let n = parseInt(location.search[6])

    if (window.scrollY == window.scrollMaxY) {
        if (location.search == "") {
            location.search = "?page=2"
        } 

        if (location.search == "?page=" + n) {
            location.search = "?page=" + (n+1)
        }
    }

    if (window.scrollY == 0) {
        if (location.search == "?page=1") {
            location.search = ""

        } else if (location.search == "?page=" + n) {
            location.search = "?page=" + (n-1)
        }
    }

})