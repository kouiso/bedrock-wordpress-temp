<?php
/**
* Template footer
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/
?>

<footer class="footer">
  <div class="footer__group">
    <div class="footer__property">
      <div class="footer__corporate-name">RITMO</div>
      <div class="footer__corporate-address">
        〒300-1283
        <br />
        茨城県牛久市奥原町3693-2
      </div>
      <div class="footer__links">
        <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="footer__link">
          <span class="footer__button-text">プライバシーポリシー</span>
        </a>
      </div>
    </div>
    <div class="footer__contact-link-wrap">
      <a href="<?php echo esc_url(home_url('/contact')); ?>">
        <button class="footer__contact-link">
          <div class="footer__contact-link-flex">
            <span class="footer__contact-link-text">
              お問い合わせ
              <br />
              <span class="footer__contact-link-subtext">※ご相談・お見積り・ご提案は無料です。</span>
            </span>
            <img src="<?php echo get_template_directory_uri(); ?>/images/footer-arrow.png" alt="矢印アイコン" width="51" height="16" class="footer__contact-link-arrow" />
          </div>
        </button>
      </a>
    </div>
  </div>
  <div class="footer__copyright">
    &copy; <?php echo date('Y'); ?> RITMO. All rights reserved.
  </div>
</footer>

<?php wp_footer(); ?>
</body>
