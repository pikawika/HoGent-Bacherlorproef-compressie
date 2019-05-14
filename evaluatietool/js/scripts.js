$(document).ready(function () {
    if ($('.img_evaluation').length) {
        new Drift(document.querySelector('.img_evaluation'), {
            paneContainer: document.querySelector('.img_evaluation_zoomed'),
            inlinePane: 900,
            zoomFactor: 5,
            inlineOffsetY: -85,
            containInline: true,
            hoverBoundingBox: true,
            touchBoundingBox: true
        });
    }
});