<?php

/**
 * EVE Online Information System Project
 * 
 * @author Andy Lo <andy.lo@gmx.com>
 * 
 * @copyright 2012 Andy Lo
 * @license GNU General Public License, version 3
 * 
 * Copyright (C) 2012 Andy Lo
 *  
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

session_start();

if(!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header("Location: logout.php");
}

?>