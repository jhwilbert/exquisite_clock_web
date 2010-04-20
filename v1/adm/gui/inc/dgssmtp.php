<?

/*
** dgssmtp.php written by James M. Sella
** Copyright (c) 2000-2004 Digital Genesis Software. All Rights Reserved.
** Released under the GPL Version 2 License.
** http://www.digitalgenesis.com
**
** Class: dgssmtp (DGS SMTP)
** Version: 0.9.1
** This class is able to deliver email via SMTP. It provides a class based
** wrapper that doesn't rely on PHPs built in mail function.
**
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class dgssmtp {
	var $data;
	function dgssmtp($server, $from, $to) {
		if(isset($this->data)) unset($this->data);
		if (!$this->setServer($server) || !$this->setFrom($from) || !$this->setTo($to))
			$this->data["error"][] = "Error: One or more of the arguments passed to dgssmtp::dgssmtp() are invalid.";
	}

	function setServer($server) {
		if(isset($this->data["server"])) unset($this->data["server"]);
		if (!is_string($server) || (!ereg("^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$", $server) && !strcmp(gethostbyname($server), $server)))
			return false;
		$this->data["server"] = trim($server);
		return true;
	}

	function setHostname($hostname) {
		if(isset($this->data["hostname"])) unset($this->data["hostname"]);
		if (!is_string($hostname) || (!ereg("^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$", $hostname) && !strcmp(gethostbyname($hostname), $hostname)))
			return false;
		$this->data["hostname"] = trim($hostname);
		return true;
	}

	function setPort($port) {
		if(isset($this->data["port"])) unset($this->data["port"]);
		if (!is_int($port) || $port < 1 || $port > 65535)
			return false;
		$this->data["port"] = $port;
		return true;
	}

	function setTimeout($timeout) {
		/* This is ignored on PHP versions older than 3.0.9. */
		if(isset($this->data["timeout"])) unset($this->data["timeout"]);
		if (!is_int($timeout))
			return false;
		$this->data["timeout"] = $timeout;
		return true;
	}

	function setFrom($from) {
		if(isset($this->data[103])) unset($this->data[103]);
		if (!is_string($from) || !$this->isEmailAddress($from))
			return false;
		$this->data[103] = trim($from);
		return true;
	}

	function setTo($to) {
		if(isset($this->data[104])) unset($this->data[104]);
		if (!is_string($to) || !$this->isEmailAddress($to))
			return false;
		$this->data[104] = trim($to);
		return true;
	}

	function setCc($cc) {
		if(isset($this->data[105])) unset($this->data[105]);
		if (!$this->isEmailAddress($cc))
			return false;
		$this->data[105] = $cc;
		return true;
	}

	function setBcc($bcc) {
		if(isset($this->data["bcc"])) unset($this->data["bcc"]);
		if (!$this->isEmailAddress($bcc))
			return false;
		$this->data["bcc"] = $bcc;
		return true;
	}

	function setReplyTo($replyTo) {
		if(isset($this->data[106])) unset($this->data[106]);
		if (!$this->isEmailAddress($replyTo))
			return false;
		$this->data[106] = $replyTo;
		return true;
	}

	function setSubject($subject) {
		if(isset($this->data[107])) unset($this->data[107]);
		/* Correct any oddball LF/CR. */
		$subject = ereg_replace("[\r\n]", " ", trim($subject));
		$this->data[107] = sprintf("Subject: %s\r\n", $subject);
		return true;
	}

	function setPriority($priority) {
		if(isset($this->data[108])) unset($this->data[108]);
		if (is_int($priority) && $priority > 0 && $priority < 6) {
			$this->data[108] = sprintf("X-Priority: %s\r\n", $priority);
		} else if (is_string($priority)) {
			switch (strtolower(trim($priority))) {
				case "lowest":
					$this->data[108] = "X-Priority: 5\r\n";
					break;
				case "low":
					$this->data[108] = "X-Priority: 4\r\n";
					break;
				case "normal":
					$this->data[108] = "X-Priority: 3\r\n";
					break;
				case "high":
					$this->data[108] = "X-Priority: 2\r\n";
					break;
				case "highest":
					$this->data[108] = "X-Priority: 1\r\n";
					break;
				default:
					return false;
			}
		} else {
			return false;
		}
		return true;
	}

	function setBody($body) {
		if(isset($this->data[199])) unset($this->data[199]);
		/* Correct any bare LF. */
		$body = ereg_replace("(\r)?\n", "\r\n", trim($body));
		$this->data[199] = sprintf("\r\n%s\r\n", $body);
		return true;
	}

	function setDebug($flag) {
		if(isset($this->data["debug"])) unset($this->data["debug"]);
		if (is_int($flag)) {
			if ($flag == 1)
				$this->data["debug"] = true;
			else if ($flag == 0)
				$this->data["debug"] = false;
			else
				return false;
			return true;
		}
		return false;
	}

	function clearErrors() {
		if(isset($this->data["error"])) unset($this->data["error"]);
		return true;
	}

	function getErrors() {
		return $this->data["error"];
	}

	function sendmail() {
		/* Sanity Check */

		if ($this->sanityCheck() == false) //Return error on insanity.
			return false;

		$this->initSendmail();

		/* Open connection to SMTP server. */
		$phpVersion = $this->getPHPVersion();
		if ($phpVersion[0] == 3 && $phpVersion[1] == 0 && $phpVersion[2] < 9) {
			$handle = fsockopen($this->data["server"], $this->data["port"], &$errno, &$errstr);
		} else {
			$handle = fsockopen($this->data["server"], $this->data["port"], &$errno, &$errstr, $this->data["timeout"]);
		}
		if (!$handle) {
			$this->data["error"][] = sprintf("Socket Error: %s (%d)", $errstr, $errno);
			return false;
		}

		if ($this->getReplyCode($handle) != 220) {
			fclose($handle);
			$this->data["error"][] = sprintf("SMTP Error: Did not recieve 220 from SMTP server. Verify that '%s:%d' is operational.", $this->data["server"], $this->data["port"]);
			return false;
		}

		/* SMTP Negotiation - Items 0 - 99 */
		if (!$this->processSMTP(0, 99, $handle, true)) 
			return false;

		/* User Data - Items 100 - 199 */
		if (!$this->processSMTP(100, 199, $handle, false)) 
			return false;

		/* SMTP Close - Items 200 - 299 */
		if (!$this->processSMTP(200, 299, $handle, true)) 
			return false;

		/* Clean Up */
		fclose($handle);
		return true;
	}

	function initSendmail() {
		/* Set defaults for needed items which are not set. */
		if (!isset($this->data["server"])) /* Default to localhost. */
			$this->setServer("localhost");
		if (!isset($this->data["port"])) /* Default to port 25. */
			$this->setPort(25);
		if (!isset($this->data["timeout"])) /* Default to 45 seconds. */
			$this->setTimeout(45);


		/* Setup items 0 - 99 that will be needed to get through SMTP negotiation. */
		$serverName = $this->data["hostname"];
		if (!$serverName)
			$serverName = getenv("SERVER_NAME");
		if (!$serverName)
			$serverName = "unknown";
		$this->data[0] = array(0 => sprintf("HELO %s\r\n", $serverName), 1 => 250);

		$this->data[1] = array(0 => sprintf("MAIL FROM: %s\r\n", $this->data[103]), 1 => 250);

		$this->data[2] = array(0 => sprintf("RCPT TO: %s\r\n", $this->data[104]), 1 => 250);

		if (isset($this->data[105])) {
			if (is_string($this->data[105])) {
				$this->data[3] = array(0 => sprintf("RCPT TO: %s\r\n", $this->data[105]), 1 => 250);
			} else {
				reset($this->data[105]);
				while(list(, $cc) = each($this->data[105])) {
					$ccArray[] = sprintf("RCPT TO: %s\r\n", trim($cc));
				}
				$this->data[3] = array(0 => $ccArray, 1 => 250);
			}
		}

		if (isset($this->data["bcc"])) {
			if (is_string($this->data["bcc"])) {
				$this->data[4] = array(0 => sprintf("RCPT TO: %s\r\n", $this->data["bcc"]), 1 => 250);
			} else {
				reset($this->data["bcc"]);
				while(list(, $bcc) = each($this->data["bcc"])) {
					$bccArray[] = sprintf("RCPT TO: %s\r\n", trim($bcc));
				}
				$this->data[4] = array(0 => $bccArray, 1 => 250);
			}
		}

		$this->data[99] = array(0 => "DATA\r\n", 1 => 354);


		/* Setup items 100 - 199 for user data. */
		$this->data[100] = sprintf("Date: %s %d %s\r\n", date("D, j M Y G:i:s"), date("Z") / 36, date("(T)"));

		$this->data[101] = sprintf("X-Mailer: %s\r\n", "DGS SMTP v0.9.1 <http://www.digitalgenesis.com>");

		$this->data[103] = sprintf("From: %s\r\n", $this->data[103]);

		$this->data[104] = sprintf("To: %s\r\n", $this->data[104]);

		if (isset($this->data[105])) {
			if (is_string($this->data[105])) {
				$cc = $this->data[105];
			} else {
				$cc = $this->joinAddresses($this->data[105]);	
			}
			$this->data[105] = sprintf("Cc: %s\r\n", $cc);
		}

		if (isset($this->data[106])) {
			if (is_string($this->data[106])) {
				$replyTo = $this->data[106];
			} else {
				$replyTo = $this->joinAddresses($this->data[106]);	
			}
			$this->data[106] = sprintf("Reply-To: %s\r\n", $replyTo);
			$this->data[106] .= "MIME-Version: 1.0\r\nContent-Type: text/html; charset=iso-8859-1\r\n";
		}


      /* Setup items 200 - 299 for SMTP close. */
		$this->data[200] = array(0 => "\r\n.\r\n", 1 => 250);

		$this->data[201] = array(0 => "QUIT\r\n", 1 => 221);

		return true;
	}

	function sanityCheck() {
		/* Take care of old errors. */
		if (isset($this->data["error"]))
			return false;

		/* Verify we have a to and from address. */
		if (!isset($this->data[103]) || !isset($this->data[104])) {
			$this->data["error"][] = "Error: Class dgssmtp has not been properly initialized. At least To and From must be set.";
			return false;
		}
		return true;
	}

	function isEmailAddress($address) {
		$error = false;
		if (is_array($address)) {
			reset($address);
			while(list(, $subAddress) = each($address)) {
				if (!is_string($subAddress) || !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[^-]([0-9a-z-]*[0-9a-z]\.)+[0-9a-z\.-]+$", $subAddress)) {
					$error = true;
					break;
				}
			}
		} else { /* RegEx stolen from manual contribs on php.net and then modified. */
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[^-]([0-9a-z-]*[0-9a-z]\.)+[0-9a-z\.-]+$", $address))
				$error = true;
		}

		if ($error) {
			$this->data["error"][] = sprintf("Invalid Address: %s", $address);
			return false;
		}

		return true;
	}

	function processSMTP($lBound, $uBound, $handle, $replyFlag) {
		$error = 0;
		for($i = $lBound; $i <= $uBound; $i++) {
			if (!isset($this->data[$i]) || !isset($this->data[$i][0]) || !isset($this->data[$i][1]))
				continue;
			if (is_array($this->data[$i])) {
				$command = $this->data[$i][0];
				$code = $this->data[$i][1];
			} else {
				$command = $this->data[$i];
				$code = -1;
			}
			if (is_string($command)) {
				$error = $this->putCommand($command, $handle);
				if ($error == -1) {
					fclose($handle);
					$this->data["error"][] = sprintf("Socket Error: Write failure to socket for command '%s'.", ereg_replace("[\r\n]", "", $command));
					return false;
				}
				if ($replyFlag && $this->getReplyCode($handle) != $code) {
					fclose($handle);
					$this->data["error"][] = sprintf("SMTP Error: Did not recieve %d from SMTP server for command '%s'.", $code, ereg_replace("[\r\n]", "", $command));
					return false;
				}
			} else {
				reset($command);
				while($error != -1 && list(, $subCommand) = each($command)) {
					$error = $this->putCommand($subCommand, $handle);
					if ($error == -1) {
						fclose($handle);
						$this->data["error"][] = sprintf("Socket Error: Write failure to socket for command '%s'.", ereg_replace("[\r\n]", "", $subCommand));
						return false;
					}
					if ($replyFlag && $this->getReplyCode($handle) != $code) {
						fclose($handle);
						$this->data["error"][] = sprintf("SMTP Error: Did not recieve %d from SMTP server for command '%s'.", $code, ereg_replace("[\r\n]", "", $subCommand));
						return false;
					}
				}
			}
		}
		return true;
	}

	function getReplyCode($handle) {
		$buffer = fgets($handle, 512);
		if (isset($this->data["debug"])) {
			printf("<- %s<BR>\n", $buffer);
			flush();
		}
		return ereg_replace ("(^[0-9]+) .*$", "\\1", $buffer);
	}

	function putCommand($buffer, $handle) {
		if (isset($this->data["debug"])) {
			printf("-> %s<BR>\n", nl2br(trim($buffer)));
			flush();
		}
		return fwrite($handle, $buffer, strlen($buffer));
	}

	function joinAddresses($addresses) {
		$buffer = "";
		reset($addresses);
		while (list(, $address) = each($addresses)) {
			if (!$this->isEmailAddress($address))
				return false;
			$buffer .= (($buffer) ? ", " : "") . trim($address);
		}
		return $buffer;
	}

	function getPHPVersion() {
		return explode(".", phpversion());
	}

}

/*
** Local Variables:
** c-basic-offset: 3
** tab-width: 3
** End:
** vim600: fdm=marker
** vim: noet ts=3 sw=3
*/

?>
