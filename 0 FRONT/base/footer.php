<!-- Add a placeholder for the Twitch embed -->
<div class="absolute bottom-10 right-10 flex flex-col">
    <div class="flex flex-row justify-betweeen bg-white-130">
        <p class="p-4 text-10 text-black">PMForDie.exe</p>
    </div>
    <div id="twitch-embed"></div>
 </div>

<!-- Load the Twitch embed script -->
<script src="https://player.twitch.tv/js/embed/v1.js"></script>

<!-- Create a Twitch.Player object. This will render within the placeholder div -->
<script type="text/javascript">
  new Twitch.Player("twitch-embed", {
    channel: "pmfordie"
  });
</script>

</body>
</html>