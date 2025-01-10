window.addEventListener("load", function () {
    const hourHand = document.querySelector(".hour-hand");
    const minuteHand = document.querySelector(".minute-hand");
    const secondHand = document.querySelector(".second-hand");
  
    function setClock() {
        const now = new Date();
  
        const seconds = now.getSeconds();
        const minutes = now.getMinutes();
        const hours = now.getHours();
  
        // Calculate degrees for each hand
        const secondsDegree = (seconds / 60) * 360 + 90; 
        const minutesDegree = (minutes / 60) * 360 + (seconds / 60) * 6 + 90;
        const hoursDegree = ((hours % 12) + minutes / 60) * 30 + 90; 
  
        // Apply transformations
        updateHand(secondHand, secondsDegree);
        updateHand(minuteHand, minutesDegree);
        updateHand(hourHand, hoursDegree);

        // Update DigClock every second with current time
        CurrentTimeToDig(now);  
    }
  
    function updateHand(hand, degree) {
        // Handle the glitch when the hand resets
        if (degree === 90) {
            hand.style.transition = "none";
        } else {
            hand.style.transition = "all 0.05s cubic-bezier(0.1, 2.7, 0.58, 1)";
        }
        hand.style.transform = `rotate(${degree}deg)`;
    }

    // Update the digital clock with the current time
    function CurrentTimeToDig(now) {
        let hours = now.getHours();
        let minutes = now.getMinutes();

        // Format the current time to 00:00
        let formattedHours = hours < 10 ? "0" + hours : hours;
        let formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
        const currentTime = `${formattedHours}:${formattedMinutes}`;
        
        // Update the digital clock with the current time
        DigClock.innerHTML = currentTime;
    }

    // Toggle between DigClock and Tijd every 5 seconds
    const DigClock = document.querySelector("#DigTijd");
    const tijd = document.querySelector("#Tijd");
    function MakeTimeDisappear() {
        if (DigClock.style.display !== "none") {
            DigClock.style.display = "none";
            tijd.style.display = "block";
        } else {
            DigClock.style.display = "block";
            tijd.style.display = "none";
        }
    }

    setInterval(setClock, 1000); 
    setInterval(MakeTimeDisappear, 5000); 
    setClock(); 
    MakeTimeDisappear(); 
});
