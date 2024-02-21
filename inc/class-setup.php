<?php
// if accessed directly, then exit
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ACF_Woo_Conditionals_Setup')) {
    class ACF_Woo_Conditionals_Setup
    {
        public function __construct()
        {
            add_filter('acf/location/rule_types', [$this, 'product_filter']);
            add_filter('acf/location/rule_values/woocommerce_product', [$this, 'product_choices']);
            add_filter('acf/location/rule_values/woocommerce_page', [$this, 'page_choices']);
            add_filter('acf/location/rule_match/woocommerce_product', [$this, 'product_conditional_render'], 10, 3);
            add_filter('acf/location/rule_match/woocommerce_page', [$this, 'page_conditional_render'], 10, 3);
        }


        // Add WooCommerce Conditional Logic
        public function product_filter($choices)
        {
            if (!isset($choices['WooCommerce'])) {
                $new_choices = array();
                foreach ($choices as $key => $value) {
                    $new_choices[$key] = $value;
                    if ($key == 'Post') { // position in the drop down in thios case after Post
                        $new_choices['WooCommerce'] = array(); // section heading
                    }
                } // end foreach choices
                $choices = $new_choices;
            } // end if not in choices
            if (!isset($choices['WooCommerce']['post'])) {
                // the array value name 'woocommerce_product' is what will be referenced in subsequent functions
                $choices['WooCommerce']['woocommerce_product'] = 'Product'; // the value in the drop down
                $choices['WooCommerce']['woocommerce_page'] = 'Page'; // the value in the drop down
            }
            return $choices;
        }

        // add product choices
        public function product_choices($choices)
        {
            // Conditional options
            $array = [
                'simple' => __('Simple', 'translate'),
                'variable' => __('Variable', 'translate'),
                'grouped' => __('Grouped', 'translate'),
                'external' => __('External', 'translate'),
            ];

            // sort array
            asort($array);

            if (isarr($array)) {
                foreach ($array as $value => $label) {
                    $choices[$value] = $label;
                }
            }
            return $choices;
        }

        // add page choices
        public function page_choices($choices)
        {
            // Conditional options
            $array = [
                'shop' => __('Shop', 'translate'),
                'cart' => __('Cart', 'translate'),
                'checkout' => __('Checkout', 'translate'),
                'myaccount' => __('Account', 'translate'),
                'terms' => __('Terms', 'translate'),
            ];

            // sort array
            asort($array);

            if (isarr($array)) {
                foreach ($array as $value => $label) {
                    $choices[$value] = $label;
                }
            }
            return $choices;
        }

        // Check product conditional logic
        public function product_conditional_render($match, $rule, $options)
        {
            $post_id = $options['post_id'];
            if (!$post_id) {
                return false;
            }
            // get product type which is what we want to check against the value in the options array
            $product = wc_get_product($post_id);
            if ($rule['operator'] == "==") {
                // check for a match to set value as true
                $match = ($product->get_type() == $rule['value']);
            } elseif ($rule['operator'] == "!=") {
                // if not match set value as false
                $match = ($product->get_type() != $rule['value']);
            }
            // return true or false based on the conditional checks
            return $match;
        }

        // Check page conditional logic
        public function page_conditional_render($match, $rule, $options)
        {
            $post_id = $options['post_id'];
            if (!$post_id) {
                return false;
            }

            if ($rule['operator'] == "==") {
                // check for a match to set value as true
                $match = ($post_id == wc_get_page_id($rule['value']));
            } elseif ($rule['operator'] == "!=") {
                // if not match set value as false
                $match = ($post_id != wc_get_page_id($rule['value']));
            }
            // return true or false based on the conditional checks
            return $match;
        }
    }

    new ACF_Woo_Conditionals_Setup();
}
