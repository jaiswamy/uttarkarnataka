<?php

/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * AAM WP_User proxy
 *
 * @package AAM
 * @version 6.9.32
 */
class AAM_Framework_Proxy_User
{

    /**
     * User status: ACTIVE
     *
     * @version 6.9.32
     */
    const STATUS_ACTIVE = 'active';

    /**
     * User status: INACTIVE
     *
     * @version 6.9.32
     */
    const STATUS_INACTIVE = 'inactive';

    /**
     * Array of allowed user statuses
     *
     * @var array
     *
     * @version 6.9.32
     */
    const ALLOWED_USER_STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE
    ];

    /**
     * Array of allowed expiration triggers
     *
     * @var array
     *
     * @version 6.9.32
     */
    const ALLOWED_EXPIRATION_TRIGGERS = [
        'logout',
        'delete',
        'change_role',
        'lock'
    ];

    /**
     * Original user object
     *
     * @var WP_User
     * @version 6.9.32
     */
    private $_user;

    /**
     * User status
     *
     * @var string
     * @access private
     * @version 6.9.32
     */
    private $_status = self::STATUS_ACTIVE;

    /**
     * Expiration date-time
     *
     * @var DateTime
     * @access private
     *
     * @version 6.9.32
     */
    private $_expires_at = null;

    /**
     * Action to trigger when user access expires
     *
     * @var array
     *
     * @access private
     * @version 6.9.32
     */
    private $_expiration_trigger = null;

    /**
     * Constructor
     *
     * Two additional attributes are initialized: status and expiration trigger.
     * The user's status is global and if user is locked, they are locked from all
     * sites in multisite setup. This is due to the fact that user can login only
     * once if WP.
     *
     * However, the expiration trigger is localized to a specific site.
     *
     * @param WP_User $user User core object
     *
     * @return void
     *
     * @access public
     * @since 6.9.32
     */
    public function __construct(WP_User $user)
    {
        $this->_user = $user;

        // Checking if there is any expiration defined for a user
        $expiration = get_user_option('aam_user_expiration', $user->ID);

        if (!empty($expiration)) {
            $this->_expires_at = new DateTime(
                '@' . $expiration['expires'], new DateTimeZone('UTC')
            );

            // Determine trigger type and additional attributes for the trigger
            // (if applicable)
            $action = isset($expiration['action']) ? $expiration['action'] : 'lock';

            $trigger = [
                'type' => $action
            ];

            // The "change-role" is a legacy setting
            if (in_array($action, ['change-role', 'change_role'], true)) {
                $trigger['to_role'] = $expiration['meta'];
            }

            $this->_expiration_trigger = $trigger;
        }

        // Get user status
        $status = get_user_meta($user->ID, 'aam_user_status', true);

        if ($status === 'locked') {
            $this->_status = self::STATUS_INACTIVE;
        } else {
            $this->_status = self::STATUS_ACTIVE;
        }
    }

    /**
     * Grant capability to user
     *
     * @param string  $capability       Capability slug
     * @param boolean $save_immediately Wether save in DB immediately or not
     *
     * @return void
     *
     * @access public
     * @throws InvalidArgumentException
     * @since 6.9.6
     */
    public function add_capability($capability, $save_immediately = false)
    {
        $sanitized = sanitize_key($capability);

        if (!is_string($sanitized) || strlen($sanitized) === 0) {
            throw new InvalidArgumentException(
                "Capability '{$capability}' is invalid"
            );
        }

        if ($save_immediately === true) {
            $this->_user->add_cap($sanitized, true);
        } else {
            $this->_user->caps[$sanitized] = true;
        }
    }

    /**
     * Deprive capability from a user
     *
     * @param string  $capability       Capability slug
     * @param boolean $save_immediately Wether save in DB immediately or not
     *
     * @return void
     *
     * @access public
     * @throws InvalidArgumentException
     * @since 6.9.32
     */
    public function remove_capability($capability, $save_immediately = false)
    {
        $sanitized = sanitize_key($capability);

        if (!is_string($sanitized) || strlen($sanitized) === 0) {
            throw new InvalidArgumentException(
                "Capability '{$capability}' is invalid"
            );
        }

        if ($save_immediately === true) {
            $this->_user->remove_cap($sanitized);
        } elseif (isset($this->_user->capabilities[$sanitized])) {
            unset($this->_user->caps[$sanitized]);
        }
    }

    /**
     * Return user attributes as array
     *
     * @return array
     *
     * @access public
     * @since 6.9.32
     */
    public function to_array()
    {
        return $this->_user->data;
    }

    /**
     * Proxy method to the original object
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     *
     * @access public
     * @since 6.9.32
     */
    public function __call($name, $arguments)
    {
        $response = null;

        if (method_exists($this->_user, $name)) {
            $response = call_user_func_array(array($this->_user, $name), $arguments);
        } else {
            _doing_it_wrong(
                static::class . '::' . $name,
                'WP_User does not have method defined',
                AAM_VERSION
            );
        }

        return $response;
    }

    /**
     * Proxy property retrieval to the original object
     *
     * @param string $name
     *
     * @return mixed
     *
     * @access public
     * @since 6.9.32
     */
    public function __get($name)
    {
        $response = null;

        if (property_exists($this, "_{$name}")) {
            $response = $this->{"_{$name}"};
        } else {
            $response = $this->_user->{$name};
        }

        return $response;
    }

    /**
     * Proxy property setting to the original object
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     *
     * @access public
     * @since 6.9.32
     */
    public function __set($name, $value)
    {
        $this->_user->{$name} = $value;
    }

}