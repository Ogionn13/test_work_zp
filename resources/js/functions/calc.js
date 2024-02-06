function  formatTimeJs(time) {
    const hours = Math.floor(time / 3600);
    const minutes = Math.floor((time % 3600) / 60);
    const seconds = time % 60;
    return hours + ' ч. ' + minutes + ' мин. ' + seconds + ' сек.';
}

