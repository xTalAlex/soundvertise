export function initMouseTrail(trailElement) {
    window.onmousemove = (e) => {
        trailElement.classList.remove("opacity-0");

        const interactable = e.target.closest(".planet"),
            interacting = interactable != null;

        const x = e.clientX - trailElement.offsetWidth / 2,
            y = e.clientY - trailElement.offsetHeight / 2;

        const keyframe = {
            transform: `translate(${x}px, ${y}px) scale(${
                interacting ? 8 : 1
            })`,
        };

        interacting
            ? trailElement.classList.add("mix-blend-hue")
            : trailElement.classList.remove("mix-blend-hue");

        trailElement.animate(keyframe, {
            duration: 0,
            fill: "forwards",
        });
    };
}
