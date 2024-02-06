<?php
/*
Plugin Name: Simple Data Parser
Plugin URI:  https://dartharth.top/articles/simple-data-parser
Description: A custom plugin to parse data from specified URLs and import it as posts.
Version:     1.0
Author:      DARTHARTH
Author URI:  https://dartharth.top
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: simple-data-parser
Domain Path: /languages
*/

add_action('admin_menu', 'simple_data_parser_menu');

function simple_data_parser_menu() {
    add_menu_page('Simple Data Parser Settings', 'Simple Data Parser', 'manage_options', 'simple-data-parser-settings', 'simple_data_parser_settings_page', 'dashicons-admin-generic');
}


function simple_data_parser_settings_page() {
    echo '<style>
        .simple-data-parser-input {
            width: 100%;
            max-width: 400px;
        }
        
        .simple-data-parser-label {
            width: 500px;
            display: inline-block;
        }
        
        #donate-button img {
            width: 110px;
        }
    </style>'

?>

    <div class="wrap">
        <h2>Simple Data Parser Settings</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields('simple-data-parser-settings-group');
                do_settings_sections('simple-data-parser-settings-group');
            ?>
            <p>
                <label class="simple-data-parser-label" for="source_page">Source Page URL:</label>
                <input class="simple-data-parser-input" type="text" id="source_page" name="source_page" value="<?php echo get_option('source_page'); ?>" />
            </p>
            <p>
                <label class="simple-data-parser-label" for="article_path_href">Article Href Path (In XPath format):</label>
                <input class="simple-data-parser-input" type="text" id="article_path_href" name="article_path_href" value="<?php echo get_option('article_path_href'); ?>" />
            </p>
            <p>
                <label class="simple-data-parser-label" for="article_title">Article Title Path (In XPath format):</label>
                <input class="simple-data-parser-input" type="text" id="article_title" name="article_title" value="<?php echo get_option('article_title'); ?>" />
            </p>
            <p>
                <label class="simple-data-parser-label" for="article_body_path">Article Body Path (In XPath format):</label>
                <input class="simple-data-parser-input" type="text" id="article_body_path" name="article_body_path" value="<?php echo get_option('article_body_path'); ?>" />
            </p>
            <p>
                <label class="simple-data-parser-label" for="clear_tags">Clear tags from class & ID</label>
                <input type="checkbox" id="clear_tags" name="clear_tags" value="1" <?php checked(1, get_option('clear_tags'), true); ?> />
            </p>
            <p>
                <label class="simple-data-parser-label" for="parse_images">Parse with image</label>
                <input type="checkbox" id="parse_images" name="parse_images" value="1" <?php checked(1, get_option('parse_images'), true); ?> />
                
            </p>
            <p>
                <label class="simple-data-parser-label" for="link_remover">Remove link</label>
                <input type="checkbox" id="link_remover" name="link_remover" value="1" <?php checked(1, get_option('link_remover'), true); ?> />

            </p>
            <p>
                <label class="simple-data-parser-label" for="remove_scripts">Remove scripts</label>
                <input type="checkbox" id="remove_scripts" name="remove_scripts" value="1" <?php checked(1, get_option('remove_scripts'), true); ?> />
            </p>
            <p>
                <label class="simple-data-parser-label" for="posts_count">Count article for parsing</label>
                <input type="number" required id="posts_count" name="posts_count" value="<?php echo esc_attr(get_option('posts_count', 1)); ?>" min="1" max="50" />
            </p>
            <p>
                <label class="simple-data-parser-label" for="fetch_delay">The delay between the parsing of each article is specified in seconds. This is done to avoid blocking your website address on the server. The minimum value is 0.5</label>
                <input type="number" required id="fetch_delay" name="fetch_delay" value="<?php echo esc_attr(get_option('fetch_delay', 1)); ?>" min="0.5" max="60" />
            </p>
            <p>
                <label class="simple-data-parser-label" for="post_category">Post category:</label>
                <?php
                    wp_dropdown_categories(array(
                        'name'             => 'post_category',
                        'orderby'          => 'name',
                        'selected'         => get_option('post_category'),
                        'show_option_none' => 'Choiсe post category',
                        'hide_empty'       => 0,
                    ));
                ?>
            </p>
            <p>
                <label class="simple-data-parser-label" for="publish_posts">Publish post</label>
                <input type="checkbox" id="publish_posts" name="publish_posts" value="1" <?php checked(1, get_option('publish_posts'), true); ?> />
            </p>

            <?php submit_button(); ?>

        </form>

        <form method="post" >
            <input type="hidden" name="action" value="simple_data_parser_fetch_posts">
            <button type="button" id="start-parsing-btn"><?php esc_attr_e('Start Parsing', 'text-domain'); ?></button>
        </form>

        <div id="parser-loading" class="spinner" style="visibility: hidden;"></div>

        <hr>

        <p><b>Support the development of this module by making a donation. Your contribution helps in maintaining and improving this free tool. Thank you for your support!</b></p>
        <div id="donate-button-container">
            <div id="donate-button"></div>
            <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
            <script>
                PayPal.Donation.Button({
                    env:'production',
                    hosted_button_id:'NG45JAN5MLDQW',
                    image: {
                        src:'https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif',
                        alt:'Donate with PayPal button',
                        title:'PayPal - The safer, easier way to pay online!',
                    }
                }).render('#donate-button');
            </script>
        </div>
        <br>
        <h3>Short Info</h3>
        <p>This guide provides basic instructions on how to use XPath to select elements within an HTML document.</p>

        <ul>
            <li><strong>Selecting Direct Children:</strong> Use <code>/</code> to select direct children. For example, <code>/html/body/div</code> selects all <code>&lt;div&gt;</code> elements that are direct children of <code>&lt;body&gt;</code>.</li>

            <li><strong>Selecting Any Descendant:</strong> Use <code>//</code> to select elements from anywhere in the document. For instance, <code>//p</code> selects all <code>&lt;p&gt;</code> elements.</li>

            <li><strong>Predicates:</strong> Use square brackets <code>[]</code> to add conditions. <code>/html/body/p[1]</code> selects the first <code>&lt;p&gt;</code> element inside <code>&lt;body&gt;</code>.</li>

            <li><strong>Attributes:</strong> Use <code>@</code> to select attributes. <code>//input[@type='text']</code> selects all text input elements.</li>

            <li><strong>Wildcards:</strong> Use <code>*</code> as a wildcard. <code>/html/body/*</code> selects all elements directly inside <code>&lt;body&gt;</code>.</li>

            <li><strong>Functions:</strong> XPath includes functions like <code>text()</code>, <code>contains()</code>, and <code>starts-with()</code>. For example, <code>//p[contains(text(),'XPath')]</code> selects <code>&lt;p&gt;</code> elements containing the text "XPath".</li>
        </ul>

        <p>Remember to test your XPath expressions to ensure they select the desired elements. Tools such as browser developer tools can be very helpful for this.</p>

        <p>If your source has a pagination, we recommend that you put the pages for the paths, how much it is displayed on one page, but preferably no more than 40, because your server can work timeout because of the script too long answer.</p>

    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#start-parsing-btn').on('click', function() {
                $('#parser-loading').css('visibility', 'visible');

                $.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'simple_data_parser_fetch_posts',
                    },
                    success: function(response) {
                        $('#parser-loading').css('visibility', 'hidden');
                        alert(response.data);

                    },
                    error: function() {
                        $('#parser-loading').css('visibility', 'hidden');
                        alert('Error occurred.');
                    }
                });
            });
        });

    </script>
<?php
    if (isset($_GET['simple_data_parser_done'])) {
        simple_data_parser_display_processed_info();
    }
}

add_action('admin_init', 'simple_data_parser_register_settings'); 
function simple_data_parser_register_settings() {
    register_setting('simple-data-parser-settings-group', 'source_page');
    register_setting('simple-data-parser-settings-group', 'source_page_pagination');
    register_setting('simple-data-parser-settings-group', 'article_title');
    register_setting('simple-data-parser-settings-group', 'article_path_href');
    register_setting('simple-data-parser-settings-group', 'article_body_path');
    register_setting('simple-data-parser-settings-group', 'clear_tags');
    register_setting('simple-data-parser-settings-group', 'parse_images');
    register_setting('simple-data-parser-settings-group', 'link_remover');
    register_setting('simple-data-parser-settings-group', 'remove_scripts');
    register_setting('simple-data-parser-settings-group', 'posts_count');
    register_setting('simple-data-parser-settings-group', 'fetch_delay');
    register_setting('simple-data-parser-settings-group', 'post_type');
    register_setting('simple-data-parser-settings-group', 'post_category');
    register_setting('simple-data-parser-settings-group', 'publish_posts');
}


add_filter('pre_update_option_posts_count', 'validate_posts_count', 10, 2);

function validate_posts_count($new_value, $old_value) {
    if (is_numeric($new_value) && $new_value >= 1 && $new_value <= 50) {
        return $new_value;
    }

    return $old_value;
}

add_action('wp_ajax_simple_data_parser_fetch_posts', 'simple_data_parser_fetch_and_create_posts');
add_action('wp_ajax_nopriv_simple_data_parser_fetch_posts', 'simple_data_parser_fetch_and_create_posts');


function simple_data_parser_fetch_and_create_posts() {
    set_time_limit(0);

    $source_url = get_option('source_page');
    $article_links_xpath = get_option('article_path_href');
    $article_title_xpath = get_option('article_title');
    $article_body_selector = get_option('article_body_path');
    $parse_images = get_option('parse_images');
    $link_remover = get_option('link_remover');
    $remove_scripts = get_option('remove_scripts');
    $number_of_posts = (int) get_option('posts_count', 1);
    $category_id = (int) get_option('post_category');
    $publish_posts = get_option('publish_posts');
    $post_status = $publish_posts ? 'publish' : 'draft';
    $remove_classes_ids = get_option('clear_tags');
    $fetch_delay = (int) get_option('fetch_delay', 1);

    $processed_info = [];

    $response = wp_remote_get($source_url);
    if (is_wp_error($response)) {
        return;
    }

    $page_content = wp_remote_retrieve_body($response);
    $dom = new DOMDocument();
    @$dom->loadHTML($page_content);
    $xpath = new DOMXPath($dom);

    $article_links = $xpath->query($article_links_xpath);
    if (!$article_links->length) {
        return;
    }

    for ($i = 0; $i < min($number_of_posts, $article_links->length); $i++) {
        $link = $article_links->item($i);
        $article_url = $link->getAttribute('href');

        $article_response = wp_remote_get($article_url);
        if (is_wp_error($article_response)) {
            continue;
        }

        $article_content = wp_remote_retrieve_body($article_response);
        $article_dom = new DOMDocument();
        @$article_dom->loadHTML($article_content);
        $article_xpath = new DOMXPath($article_dom);

        $article_title_nodes = $article_xpath->query($article_title_xpath);
        $article_title = $article_title_nodes->length > 0 ? trim($article_title_nodes->item(0)->nodeValue) : 'No title';

        $article_body_nodes = $article_xpath->query($article_body_selector);
        $article_body = $article_body_nodes->length > 0 ? $article_dom->saveHTML($article_body_nodes->item(0)) : '';

        if ($parse_images) {
            $images = $article_xpath->query('//img', $article_dom);

            foreach ($images as $img) {
                $img_url = $img->getAttribute('src');

                $upload = simple_data_parser_upload_image($img_url);

                if ($upload && is_array($upload)) {
                    $img->setAttribute('src', $upload['url']);
                }
            }

            $article_content = $article_dom->saveHTML();
        }

        if ($remove_classes_ids) {
            $removed_classid = '/<([a-z][a-z0-9]*)[^>]*\s(class|id)="[^"]*"[^>]*>/i';

            $article_body = preg_replace($removed_classid, '<$1>', $article_body);
        }

        if ($link_remover) {
            $replaced_links = '/<a\b[^>]*>.*?<\/a>/is';
            $article_body = preg_replace($replaced_links, '', $article_body);
        }

        if ($remove_scripts) {
            $replaced_script = '/<script\b[^>]*>(.*?)<\/script>/is';
            $article_body = preg_replace($replaced_script, '', $article_body);
        }

        $post_id = wp_insert_post(array(
            'post_title'   => sanitize_text_field($article_title),
            'post_content' => $article_body,
            'post_status'  => $post_status,
            'post_author'  => 1,
            'post_category'=> array($category_id)
        ));

        $processed_info[] = "Page /{$article_title}/ processed";
        $processed_info[] = "Post /{$article_title}/ created";

        if ($i < $number_of_posts - 1) {
            sleep($fetch_delay);
        }
    }

    update_option('simple_data_parser_processed_info', $processed_info);

    wp_send_json_success('Parsing ended successfully.');
}

add_action('wp_head', 'my_plugin_add_ajaxurl' );
function my_plugin_add_ajaxurl() {
    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
</script>';
}


function simple_data_parser_remove_classes_ids($content) {
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $xpath = new DOMXPath($dom);

    foreach ($xpath->query('//*[@class]') as $node) {
        $node->removeAttribute('class');
    }

    foreach ($xpath->query('//*[@id]') as $node) {
        $node->removeAttribute('id');
    }

    return $dom->saveHTML();
}

function simple_data_parser_upload_image($image_url) {
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $tmp = download_url($image_url);

    if (is_wp_error($tmp)) {
        return false;
    }

    $file_array = array(
        'name' => basename($image_url),
        'tmp_name' => $tmp
    );

    $id = media_handle_sideload($file_array, 0);

    if (is_wp_error($id)) {
        @unlink($file_array['tmp_name']);
        return false;
    }

    return wp_get_attachment_url($id);
}

function simple_data_parser_display_processed_info() {
    $processed_info = get_option('simple_data_parser_processed_info', []);

    if (!empty($processed_info)) {
        echo '<div class="notice notice-success">';
        foreach ($processed_info as $info) {
            echo '<p>' . esc_html($info) . '</p>';
        }
        echo '<p>--------------------------------------</p>';
        echo '<p>Total processed ' . count($processed_info) / 2 . ' pages</p>';
        echo '<p>Total created ' . count($processed_info) / 2 . ' posts</p>';
        echo '</div>';

        delete_option('simple_data_parser_processed_info');
    }
}


simple_data_parser_display_processed_info();


add_action('admin_post_simple_data_parser_fetch_posts', 'simple_data_parser_handle_form_submission');

function simple_data_parser_handle_form_submission() {
    simple_data_parser_fetch_and_create_posts();

    exit;
}
