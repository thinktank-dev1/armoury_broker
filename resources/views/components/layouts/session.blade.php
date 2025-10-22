<script>
    let inactivityTime = 0;
    const maxInactivity = 5 * 60;
    const countdownStart = 30;
    let countdownTimer;
    let countdownRemaining = countdownStart;

    function resetTimer() {
        inactivityTime = 0;
        clearInterval(countdownTimer);
        document.getElementById('logout-warning')?.classList.add('hidden');
    }
    
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onscroll = resetTimer;
    document.onclick = resetTimer;

    setInterval(() => {
        inactivityTime++;
        if(inactivityTime === maxInactivity - countdownStart) {
            showCountdown();
        }
        if (inactivityTime >= maxInactivity) {
            window.location.href = "{{ route('logout') }}";
        }
    }, 1000);

    function showCountdown() {
        $('#logout-warning').modal('show');
        countdownRemaining = countdownStart;

        countdownTimer = setInterval(() => {
            countdownRemaining--;
            document.getElementById('countdown').innerText = countdownRemaining;

            if (countdownRemaining <= 0) {
                clearInterval(countdownTimer);
            }
        }, 1000);
    }

    function stayLoggedIn() {
        $('#logout-warning').modal('hide');
        fetch("{{ route('keep-alive') }}", { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
        .then(() => resetTimer());
    }
</script>