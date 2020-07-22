<?php

use KevinBatdorf\App; ?>

<div style="border-bottom:1px solid #e4e4e4;padding:30px 30px 30px 0;font-size:14px;line-height:1.3">
    <div style="display:flex">
        <div style="width:205px;padding:0 20px 0 0">
            <p style="font-weight:600;margin:0;"><?php _e( 'User Data', App::$slug ); ?></p>
        </div>
            <div style="flex:1">
                <div style="background: #E5E5E5;border-radius:4px;color:#666;font-size:14px;margin-bottom:20px;padding:15px;">
                    <?php _e('Share this on your website (press to copy)', App::$slug ); ?>
                    <span x-data="{
                        copied: false,
                        showCopied() {
                            this.copied = true
                            setTimeout(() => {
                                this.copied = false
                            }, 2000)
                        }
                        }">
                        <button
                            role="button"
                            title="press to copy"
                            style="cursor:pointer;padding:0;border:0;"
                            @click="
                                var range = document.createRange();
                                range.selectNode($event.target);
                                window.getSelection().removeAllRanges();
                                window.getSelection().addRange(range);
                                copied || document.execCommand('copy')
                            "
                            @copy.prevent="$event.clipboardData.setData('text/plain', $el.innerText);showCopied()"><code style="padding:0">[<?php echo App::$slug ?>]</code></button>
                        <span style="font-style:italic;margin-left:0.25rem" x-show.transition.opacity.duration.500ms="copied" x-cloak>
                            <?php _e('Copied!', App::$slug ); ?>
                        </span>
                    </span>
                </div>
                <?php include dirname( __FILE__ ) . '/user-data-table.php'; ?>
            </div>
    </div>
</div>