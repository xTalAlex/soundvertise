export function initMouseTrail(trailElement) {
    window.onmousemove = (e) => {
        trailElement.classList.remove("opacity-0");

        const interactable = e.target.closest(".size-44"),
            interacting = interactable != null;

        const interactable2 = e.target.closest(".orbit"),
            interacting2 = interactable2 != null;

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

        interacting2
            ? trailElement.classList.add("bg-emerald-500") &&
              trailElement.classList.remove("bg-violet-500")
            : trailElement.classList.remove("bg-emerald-500") &&
              trailElement.classList.add("bg-violet-500");

        trailElement.animate(keyframe, {
            duration: 0,
            fill: "forwards",
        });
    };
}
