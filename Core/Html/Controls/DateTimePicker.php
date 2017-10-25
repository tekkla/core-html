<?php
namespace Core\Html\Controls;

use Core\Html\Form\Input;

/**
 * DateTimePicker.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 *         
 * @uses https://eonasdan.github.io/bootstrap-datetimepicker/
 * @uses http://momentjs.com/
 *      
 *       This control needs the js libs above. Make sure to include them.
 */
class DateTimePicker extends Input
{

    protected $css = [
        'form-datepicker'
    ];

    /**
     * Default date format: ISO date
     *
     * @var string
     */
    protected $format = 'YYYY-MM-DD';

    /**
     * En/disables the date picker
     *
     * @var bool
     */
    protected $option_pick_date = true;

    /**
     * En/disables the time picker
     *
     * @var bool
     */
    protected $option_pick_time = true;

    /**
     * En/disables the minutes picker
     *
     * @var bool
     */
    protected $option_use_minutes = true;

    /**
     * En/disables the seconds picker
     *
     * @var bool
     */
    protected $option_use_seconds = true;

    /**
     * Minute stepping
     *
     * @var int
     */
    protected $option_minute_stepping = 1;

    /**
     * Minimum date
     *
     * @var string
     */
    protected $option_min_date = "1/1/1970";

    /**
     * Maximum date
     *
     * @var string
     */
    protected $option_max_date = 'today +50 years';

    /**
     * Default language locale
     *
     * @var string
     */
    protected $option_locale = 'en';

    /**
     * Default date
     *
     * @var string
     */
    protected $option_default_date = '';

    /**
     * Array of dates that cannot be selected
     *
     * @var array
     */
    protected $option_disabled_dates = [];

    /**
     * Array of dates that can be selected
     *
     * @var array
     */
    protected $option_enabled_dates = [
        '1/1/1970'
    ];

    /**
     * Icons to use
     */
    protected $option_icons = [
        'time' => 'fa fa-time',
        'date' => 'fa fa-calendar',
        'up' => 'fa fa-chevron-up',
        'down' => 'fa fa-chevron-down'
    ];

    /**
     * Today indicator
     *
     * @var bool
     */
    protected $option_show_today = true;

    /**
     * Use current date.
     * When true, picker will set the value to the current date/time (respects picker's format)
     *
     * @var bool
     */
    protected $option_use_current = true;

    /**
     * Use "strict" when validating dates
     *
     * @var bool
     */
    protected $option_use_strict = false;

    /**
     * Remember the options set by method
     *
     * @var array
     */
    protected $set_options = [];

    /**
     * Language to load
     *
     * @var string
     */
    protected $language;

    private $config;

    /**
     * Returns set default date.
     *
     * @return string
     */
    public function getDefaultDate(): string
    {
        return $this->option_default_date;
    }

    /**
     * Sets the default date
     *
     * Can be timestamp or DateTime object or string
     *
     * @param string $date
     *
     * @return \Core\Html\Controls\DateTimePicker
     */
    public function setDefaultDate(string $date): DateTimePicker
    {
        $this->option_default_date = $date;
        $this->set_options['default_date'] = 'defaultDate';
        
        return $this;
    }

    /**
     * Returns set disabled dates.
     *
     * @return array
     */
    public function getDisabledDates(): array
    {
        return $this->option_disabled_dates;
    }

    /**
     * Sets disabled dates.
     * Accepts a single date or a list of dates in an array.
     *
     * @param string|array $dates
     *
     * @return \Core\Html\Controls\DateTimePicker
     */
    public function setDisabledDates($dates): DateTimePicker
    {
        if (! is_array($dates)) {
            $dates = (array) $dates;
        }
        
        $this->option_disabled_dates = $dates;
        $this->set_options['disabled_dates'] = 'disabledDates';
        
        return $this;
    }

    /**
     * Return set enabled days.
     *
     * @return array
     */
    public function getEnabledDates(): array
    {
        return $this->option_enabled_dates;
    }

    /**
     * Sets enabled dates.
     * Accepts a single date or a list of dates in an array.
     *
     * @param string|array $dates
     *
     * @return \Core\Html\Controls\DateTimePicker
     */
    public function setEnabledDates($dates): DateTimePicker
    {
        if (! is_array($dates)) {
            $dates = (array) $dates;
        }
        
        $this->option_enabled_dates = $dates;
        $this->set_options['enablede_dates'] = 'enabledDates';
        
        return $this;
    }

    /**
     * Set flag to use or not use the show today button.
     * This option is "true" by default.
     * Calling this method without parameter returns the currently set value.
     *
     * @param bool $bool
     *
     * @return boolean|\Core\Html\Controls\DateTimePicker
     */
    public function showToday(bool $bool = null)
    {
        if (isset($bool)) {
            
            $this->option_show_today = is_bool($bool) ? $bool : false;
            $this->set_options['show_today'] = 'showToday';
            
            return $this;
        } else {
            return $this->option_show_today;
        }
    }

    /**
     * Set flag to use or not use the current button
     *
     * This option is "true" by default.
     * Calling this method without parameter returns the currently set value.
     *
     * @param bool $bool
     *
     * @return boolean|\Core\Html\Controls\DateTimePicker
     */
    public function useCurrent(bool $bool = null)
    {
        if (isset($bool)) {
            
            $this->option_use_current = is_bool($bool) ? $bool : false;
            $this->set_options['use_current'] = 'useCurrent';
            
            return $this;
        } else {
            return $this->option_show_today;
        }
    }

    /**
     * Returns set format.
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Sets format.
     *
     * @param string $format
     *
     * @return \Core\Html\Controls\DateTimePicker
     */
    public function setFormat(string $format): DateTimePicker
    {
        $this->format = $format;
        
        return $this;
    }

    /**
     * Returns set min date.
     *
     * @return string
     */
    public function getMinDate(): string
    {
        return $this->option_min_date;
    }

    /**
     * Sets min date
     *
     * @param string $start_date
     *
     * @return \Core\Html\Controls\DateTimePicker
     */
    public function setMinDate(string $start_date): DateTimePicker
    {
        $this->option_min_date = $start_date;
        $this->set_options['min_date'] = 'minDate';
        
        return $this;
    }

    /**
     * Returns set max dateoption.
     *
     * @return string
     */
    public function getMaxDate(): string
    {
        return $this->option_max_date;
    }

    /**
     * Sets max date.
     *
     * @param string $max_date
     *
     * @return \Core\Html\Controls\DateTimePicker
     */
    public function setMaxDate(string $max_date): DateTimePicker
    {
        $this->option_max_date = $max_date;
        $this->set_options['max_date'] = 'maxDate';
        
        return $this;
    }

    /**
     * Returns set minute stepping option
     *
     * @return int
     */
    public function getMinuteStepping(): int
    {
        return $this->option_minute_stepping;
    }

    /**
     * Sets minute stepping.
     *
     * @param int $minute_step
     *
     * @throws ControlException
     *
     * @return \Core\Html\Controls\DateTimePicker
     */
    public function setMinuteStepping(int $minute_step): DateTimePicker
    {
        $minute_step = (int) $minute_step;
        
        if (empty($minute_step)) {
            Throw new ControlException('Datepicker minute step has to be of type integer');
        }
        
        if ($minute_step < 1 || $minute_step > 59) {
            Throw new ControlException('Datepicker minute step has to be between 1 and 59.');
        }
        
        $this->option_minute_stepping = $minute_step;
        $this->set_options['minute_stepping'] = 'minuteStepping';
        
        return $this;
    }

    /**
     * Set flag for using datepicker
     *
     * This option is "true" by default.
     * Calling this method without parameter returns the currently set value.
     *
     * @param bool $bool
     *
     * @return bool|\Core\Html\Controls\DateTimePicker
     */
    public function usePickDate(bool $bool = null)
    {
        if (isset($bool)) {
            
            $this->option_pick_date = (bool) $bool;
            $this->set_options['pick_date'] = 'pickDate';
            
            return $this;
        } else {
            return $this->option_pick_date;
        }
    }

    /**
     * Set flag for using timepicker
     *
     * This option is "true" by default.
     * Calling this method without parameter returns the currently set value.
     *
     * @param bool $bool
     *
     * @return bool|\Core\Html\Controls\DateTimePicker
     */
    public function usePickTime(bool $bool = null)
    {
        if (isset($bool)) {
            
            $this->option_pick_time = (bool) $bool;
            $this->set_options['pick_time'] = 'pickTime';
            
            return $this;
        } else {
            return $this->option_pick_time;
        }
    }

    /**
     * Set flag to use or not use minutes in timepicker
     *
     * This option is "true" by default.
     * Calling this method without parameter returns the currently set value.
     *
     * @param bool $bool
     * @return bool|\Core\Html\Controls\DateTimePicker
     */
    public function useMinutes(bool $bool = null)
    {
        if (isset($bool)) {
            
            $this->option_use_minutes = (bool) $bool;
            $this->set_options['use_minutes'] = 'useMinutes';
            
            return $this;
        } else {
            return $this->option_use_minutes;
        }
    }

    /**
     * Set flag to use or not use seconds int timepicker.
     *
     * This option is "true" by default.
     * Calling this method without parameter returns the currently set value.
     *
     * @param bool $bool
     *
     * @return bool|\Core\Html\Controls\DateTimePicker
     */
    public function useSeconds(bool $bool = null)
    {
        if (isset($bool)) {
            
            $this->option_use_seconds = (bool) $bool;
            $this->set_options['use_seconds'] = 'useSeconds';
            
            return $this;
        } else {
            return $this->option_use_seconds;
        }
    }

    /**
     * Sets locale to use
     *
     * @param string $locale
     *
     * @return DateTimePicker
     */
    public function setLocale(string $locale): DateTimePicker
    {
        $this->option_locale = $locale;
        $this->set_options['locale'] = 'locale';
        
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Html\Form\Input::build()
     *
     * @throws ControlException
     */
    public function build()
    {
        // Prepare options object
        $options = new \stdClass();
        
        // Set options which are set active
        foreach ($this->set_options as $option) {
            
            switch ($option) {
                
                // Check date
                case 'option_disabled_days':
                case 'option_enabled_dates':
                    
                    $options->{$option} = [];
                    
                    foreach ($this->{$option} as $date) {
                        
                        if (! is_int($date) || ! $date instanceof \DateTime || ! is_string($date)) {
                            Throw new ControlException('Datepicker controls ' . $option . ' date must by of type integer (timestamp), string or DateTime object.', 1000);
                        }
                        
                        if (is_string($date)) {
                            $date = strtotime($date);
                        }
                        
                        if ($date instanceof \DateTime) {
                            $date = $date->getTimestamp();
                        }
                        
                        $options->{$option}[] = date('Y-m-d', $date);
                    }
                    
                    break;
                
                default:
                    
                    $options->{$option} = $this->{'option_' . $option};
                    break;
            }
        }
        
        $options->format = $this->format;
        
        // Add options as json encoded data attribute
        $this->data['datepicker-options'] = json_encode($options);
        
        return parent::build();
    }
}
