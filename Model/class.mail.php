<?php
session_start();
class Mail {
	
	private $from;
	private $to;
	private $getterName;
	private $giverName;
	private $message;
	private $subject;
	
	/**
	 * @return the $from
	 */
	public function getFrom() {
		return $this->from;
	}

	/**
	 * @return the $to
	 */
	public function getTo() {
		return $this->to;
	}

	/**
	 * @return the $message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return the $subject
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param field_type $from
	 */
	public function setFrom($from) {
		$this->from = $from;
	}

	/**
	 * @param field_type $to
	 */
	public function setTo($to) {
		$this->to = $to;
	}

	/**
	 * @param field_type $message
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * @param field_type $subject
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	public function sendMail() {
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= "From: ".$this->from;
		mail($this->to,$this->subject,$this->message,$headers);
	}
}
?>