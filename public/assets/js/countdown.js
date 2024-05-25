async function getServerTime() {
    return new Date();
}

async function updateCountdown() {
    const serverTime = await getServerTime();
    const nextMidnight = new Date(serverTime.getFullYear(), serverTime.getMonth(), serverTime.getDate() + 1);
    const timeDifference = nextMidnight - serverTime;

    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

    const formattedTime = `Resets in ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    document.getElementById('countdown').textContent = formattedTime; // Clear previous value and update with new value
}

setInterval(updateCountdown, 1000);
updateCountdown();