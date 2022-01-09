</div>
<script>
const userId = '<?php echo $_SESSION["user_id"]; ?>';
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js" integrity="sha256-hlKLmzaRlE8SCJC1Kw8zoUbU8BxA+8kR3gseuKfMjxA=" crossorigin="anonymous"></script>
<script src="js/notifs.js"></script>
<?php
if($footermore){
  echo $footermore;
}
?>
</body>
</html>
