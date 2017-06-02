    <footer class="Footer">
      <div class="container">
        <?php
          if ( file_exists(TEMPLATEPATH . '/partials/partners.php')) {
            include TEMPLATEPATH . '/partials/partners.php';
          }
        ?>

        <hr class="Footer-separator">

        <div class="Footer-copy">
          <p>Copyright &copy; <?php echo date('Y') ?>. Derechos Reservados</p>
          <p>Desarrollado por <a href="http://watson.pe" target="_blank" rel="noopener noreferrer">Agencia Watson.</a></p>
        </div>
      </div>
    </footer>

    <script>
      _root_ = '<?php echo home_url(); ?>'
    </script>

    <?php wp_footer(); ?>
  </body>
</html>
