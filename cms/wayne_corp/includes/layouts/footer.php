<div id="footer">Copyright <?php echo date("Y")?>, Wayne Corp.</div>
	</body>
</html>
<?php if (isset($connection)) {
	mysqli_close($connection);
}?>