<?php

/**
 * 
 */
class BackgroundProcess {

    /**
     *
     * @var string
     */
    private $_exec;

    /**
     *
     * @var string 
     */
    protected $_command;

    /**
     *
     * @var string 
     */
    protected $_output_file;

    /**
     *
     * @var string 
     */
    protected $_pid_file;

    /**
     * 
     * @param type $command
     * @param type $output_file
     * @param type $pid_file
     */
    public function __construct($command = NULL, $output_file = NULL, $pid_file = NULL) {
        if (!empty($command)) {
            $this->setCommand($command);
        }

        if (!empty($output_file)) {
            $this->setOutputFile($output_file);
        }

        if (!empty($pid_file)) {
            $this->setPidFile($pid_file);
        }
    }

    /**
     * 
     * @param type $command
     */
    public function setCommand($command) {
        $this->_command = $command;
    }

    /**
     * 
     * @return type
     * @throws \Exception
     */
    public function getCommand() {
        if (empty($this->_command)) {
            throw new \Exception('Command not set');
        }

        return $this->_command;
    }

    /**
     * 
     * @param type $output_file
     * @param type $force_create
     * @throws \Exception
     */
    public function setOutputFile($output_file, $force_create = TRUE) {
        $file_exists = \file_exists($output_file);
        if (!$file_exists && !$force_create) {
            throw new \Exception('Output file doesn\'t exists');
        } else if (!$file_exists && $force_create) {
            if (!\touch($output_file)) {
                throw new \Exception('Unable to create output file');
            }
        }

        $this->_output_file = $output_file;
    }

    /**
     * 
     * @param type $auto_create
     * @return type
     * @throws \Exception
     */
    public function getOutputFile($auto_create = TRUE) {
        if (empty($this->_output_file)) {
            if ($auto_create) {
                $this->setOutputFile('php-bg-output-' . time() . '.txt');
            } else {
                throw new \Exception('Output file not set');
            }
        }

        return $this->_output_file;
    }

    /**
     * 
     * @param type $pid_file
     * @param type $force_create
     * @throws \Exception
     */
    public function setPidFile($pid_file, $force_create = FALSE) {
        $file_exists = \file_exists($pid_file);
        if (!$file_exists && !$force_create) {
            throw new \Exception('Pid file doesn\'t exists');
        } else if (!$file_exists && $force_create) {
            if (!\touch($pid_file)) {
                throw new \Exception('Unable to create pid file');
            }
        }

        $this->_pid_file = $pid_file;
    }

    /**
     * 
     * @param type $auto_create
     * @return type
     * @throws \Exception
     */
    public function getPidFile($auto_create = TRUE) {
        if (empty($this->_pid_file)) {
            if ($auto_create) {
                $this->setOutputFile('php-bg-pid-' . time() . '.txt', TRUE);
            } else {
                throw new \Exception('Pid file not set');
            }
        }

        return $this->_pid_file;
    }

    /**
     * 
     */
    public function setExec() {
        $this->_exec = sprintf("%s > %s 2>&1 & echo $! >> %s", $this->getCommand(), $this->getOutputFile(), $this->getPidFile());
    }

    /**
     * 
     * @return type
     */
    public function getExec() {
        if (empty($this->_exec)) {
            $this->setExec();
        }

        return $this->_exec;
    }

    /**
     * 
     * @throws \Exception
     */
    public function execute() {
        try {
            \exec($this->getExec());
        } catch (\Exception $exc) {
            throw $exc;
        }
    }

}
