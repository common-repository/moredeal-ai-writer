<?php

namespace MoredealAiWriter\application\helpers;

defined( '\ABSPATH' ) || exit;

if ( ! defined( 'MB_ENABLED' ) ) {
    if ( extension_loaded( 'mbstring' ) ) {
        define( 'MB_ENABLED', true );
    } else {
        define( 'MB_ENABLED', false );
    }
}

/**
 * FormValidator class file
 *
 * @author MoredealAiWriter
 */
class FormValidator {

    /**
     * Required
     *
     * @param  $str
     *
     * @return    bool
     */
    public static function required( $str ): bool {
        return is_array( $str ) ? (bool) count( $str ) : ( trim( $str ) !== '' );
    }

    /**
     * 检查License格式
     *
     * @param $value string
     *
     * @return bool true: 格式正确
     */
    public static function licenseFormat( string $value ): bool {

        if ( preg_match( '/[^0-9a-zA-Z_~\-]/', $value ) ) {
            return false;
        }
        if ( strlen( $value ) !== 32 && ! preg_match( '/^\w{8}-\w{4}-\w{4}-\w{4}-\w{12}$/', $value ) ) {
            return false;
        }

        return true;
    }

    /**
     * Required
     *
     * @param  $num
     *
     * @return    bool
     */
    public static function numberValidator( $num ): bool {
        return $num >= 2 && $num <= 5;
    }

    public static function numberValidator3( $num ): bool {
        return $num >= 3 && $num <= 6;
    }

    /**
     * Required
     *
     * @param  $num
     *
     * @return    bool
     */
    public static function numberValidator2( $num ): bool {
        if ( empty( $num ) ) {
            return true;
        }

        return $num >= 0;
    }

    // --------------------------------------------------------------------

    /**
     * Performs a Regular Expression match test.
     *
     * @param string
     * @param string    regex
     *
     * @return    bool
     */
    public static function regex_match( $str, $regex ) {
        return (bool) preg_match( $regex, $str );
    }

    // --------------------------------------------------------------------

    /**
     * Minimum Length
     *
     * @param string
     * @param string
     *
     * @return    bool
     */
    public static function min_length( $str, $val ) {
        if ( ! is_numeric( $val ) ) {
            return false;
        } else {
            $val = (int) $val;
        }

        return ( MB_ENABLED === true ) ? ( $val <= mb_strlen( $str ) ) : ( $val <= strlen( $str ) );
    }

    // --------------------------------------------------------------------

    /**
     * Max Length
     *
     * @param string
     * @param string
     *
     * @return    bool
     */
    public static function max_length( $str, $val ) {
        if ( ! is_numeric( $val ) ) {
            return false;
        } else {
            $val = (int) $val;
        }

        return ( MB_ENABLED === true ) ? ( $val >= mb_strlen( $str ) ) : ( $val >= strlen( $str ) );
    }

    // --------------------------------------------------------------------

    /**
     * Exact Length
     *
     * @param string
     * @param string
     *
     * @return    bool
     */
    public static function exact_length( $str, $val ) {
        if ( ! is_numeric( $val ) ) {
            return false;
        } else {
            $val = (int) $val;
        }

        return ( MB_ENABLED === true ) ? ( mb_strlen( $str ) === $val ) : ( strlen( $str ) === $val );
    }

    // --------------------------------------------------------------------

    /**
     * Valid URL
     *
     * @param string $str
     *
     * @return    bool
     */
    public static function valid_url( $str ) {
        if ( empty( $str ) ) {
            return false;
        }

        $pattern = '/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i';

        if ( is_string( $str ) && strlen( $str ) < 2000 ) {
            if ( preg_match( $pattern, $str ) ) {
                return true;
            }
        }

        return false;

        /*
          if (empty($str))
          {
          return FALSE;
          } elseif (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $str, $matches))
          {
          if (empty($matches[2]))
          {
          return FALSE;
          } elseif (!in_array($matches[1], array('http', 'https'), TRUE))
          {
          return FALSE;
          }

          $str = $matches[2];
          }

          $str = 'http://' . $str;

          // There's a bug affecting PHP 5.2.13, 5.3.2 that considers the
          // underscore to be a valid hostname character instead of a dash.
          // Reference: https://bugs.php.net/bug.php?id=51192
          if (version_compare(PHP_VERSION, '5.2.13', '==') === 0 OR version_compare(PHP_VERSION, '5.3.2', '==') === 0)
          {
          sscanf($str, 'http://%[^/]', $host);
          $str = substr_replace($str, strtr($host, array('_' => '-', '-' => '_')), 7, strlen($host));
          }

          return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
         *
         */
    }

    // --------------------------------------------------------------------

    /**
     * Valid Email
     *
     * @param string
     *
     * @return    bool
     */
    public static function valid_email( $str ) {
        return (bool) filter_var( $str, FILTER_VALIDATE_EMAIL );
    }

    // --------------------------------------------------------------------
    // --------------------------------------------------------------------

    /**
     * Alpha
     *
     * @param string
     *
     * @return    bool
     */
    public static function alpha( $str ) {
        return ctype_alpha( $str );
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric
     *
     * @param string
     *
     * @return    bool
     */
    public static function alpha_numeric( $str ) {
        return ctype_alnum( (string) $str );
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric w/ spaces
     *
     * @param string
     *
     * @return    bool
     */
    public static function alpha_numeric_spaces( $str ) {
        return (bool) preg_match( '/^[A-Z0-9 ]+$/i', $str );
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @param string
     *
     * @return    bool
     */
    public static function alpha_dash( $str ) {
        return (bool) preg_match( '/^[a-z0-9_-]+$/i', $str );
    }

    // --------------------------------------------------------------------

    /**
     * Numeric
     *
     * @param string
     *
     * @return    bool
     */
    public static function numeric( $str ) {
        return (bool) preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $str );
    }

    // --------------------------------------------------------------------

    /**
     * Integer
     *
     * @param string
     *
     * @return    bool
     */
    public static function integer( $str ) {
        return (bool) preg_match( '/^[\-+]?[0-9]+$/', $str );
    }

    // --------------------------------------------------------------------

    /**
     * Decimal number
     *
     * @param string
     *
     * @return    bool
     */
    public static function decimal( $str ) {
        return (bool) preg_match( '/^[\-+]?[0-9]+\.[0-9]+$/', $str );
    }

    // --------------------------------------------------------------------

    /**
     * Greater than
     *
     * @param string
     * @param int
     *
     * @return    bool
     */
    public static function greater_than( $str, $min ) {
        return is_numeric( $str ) ? ( $str > $min ) : false;
    }

    // --------------------------------------------------------------------

    /**
     * Equal to or Greater than
     *
     * @param string
     * @param int
     *
     * @return    bool
     */
    public static function greater_than_equal_to( $str, $min ) {
        return is_numeric( $str ) ? ( $str >= $min ) : false;
    }

    // --------------------------------------------------------------------

    /**
     * Less than
     *
     * @param string
     * @param int
     *
     * @return    bool
     */
    public static function less_than( $str, $max ) {
        return is_numeric( $str ) ? ( $str < $max ) : false;
    }

    // --------------------------------------------------------------------

    /**
     * Equal to or Less than
     *
     * @param string
     * @param int
     *
     * @return    bool
     */
    public static function less_than_equal_to( $str, $max ) {
        return is_numeric( $str ) ? ( $str <= $max ) : false;
    }

    // --------------------------------------------------------------------

    /**
     * Is a Natural number  (0,1,2,3, etc.)
     *
     * @param string
     *
     * @return    bool
     */
    public static function is_natural( $str ) {
        return ctype_digit( (string) $str );
    }

    // --------------------------------------------------------------------

    /**
     * Is a Natural number, but not a zero  (1,2,3, etc.)
     *
     * @param string
     *
     * @return    bool
     */
    public static function is_natural_no_zero( $str ) {
        return ( $str != 0 && ctype_digit( (string) $str ) );
    }

    // --------------------------------------------------------------------

    /**
     * Valid Base64
     *
     * Tests a string for characters outside of the Base64 alphabet
     * as defined by RFC 2045 http://www.faqs.org/rfcs/rfc2045
     *
     * @param string
     *
     * @return    bool
     */
    public static function valid_base64( $str ) {
        return ( base64_encode( base64_decode( $str ) ) === $str );
    }

    // --------------------------------------------------------------------

    /**
     * Prep URL
     *
     * @param string
     *
     * @return    string
     */
    public static function prep_url( $str = '' ) {
        if ( $str === 'http://' or $str === '' ) {
            return '';
        }

        if ( strpos( $str, 'http://' ) !== 0 && strpos( $str, 'https://' ) !== 0 ) {
            return 'http://' . $str;
        }

        return $str;
    }

    // --------------------------------------------------------------------

    /**
     * Convert PHP tags to entities
     *
     * @param string
     *
     * @return    string
     */
    public static function encode_php_tags( $str ) {
        return str_replace( array( '<?', '?>' ), array( '&lt;?', '?&gt;' ), $str );
    }

}

if ( ! function_exists( 'affegg_intval_bool' ) ) {

    function affegg_intval_bool( $str ) {
        return intval( (bool) $str );
    }

}