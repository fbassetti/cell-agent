var sw_msg = new Array(
"Welcome to the Smart Wizard. This wizard will help you quickly set up the Network Camera to run on your network.",
": Enter a descriptive name for the camera. For example, camera 1.",
": Enter a descriptive name for the location used by the camera. For example, meeting room 1.",
": Enter the administrator password twice to set and confirm the password to access the camera's Configuration Utility.",
": Select this option when your network uses the DHCP server. When the camera starts up, it will be assigned an IP address from the DHCP server automatically.",
": Select this option to assign the IP address for the camera directly. You can use IP Finder to obtain the related setting values.",
"- IP Address: For example, enter the default setting ",
"- Subnet Mask: For example, enter the default setting ",
"- Default Gateway: For example, enter the default setting ",
"- Primary/Secondary DNS: Enter the DNS that are provided by your ISP.",
": Select this option when you use a direct connection via the ADSL modem. You should have a PPPoE account from your Internet service provider. Enter the user name and password in the following boxes. Please note that once the camera get an IP address from the ISP as starting up, it automatically sends a notification email to you. Therefore, when you select PPPoE as your connecting type, you have to set up the email configuration in next step .",
": Enter the mail server address. For example, mymail.com.",
": Enter the email address of the user who will send the email. For example, John@mymail.com.",
": If the mail server needs to login, please select SMTP.",
": Enter the user name to login the mail server.",
": Enter the password to login the mail server.",
": Enter the first email address of the user who will receive the email.",
": Enter the second email address of the user who will receive the email.",
": To connect the camera to a specified access point, set a SSID for the camera to correspond with the access point's ESS-ID. To connect the camera to an Ad-Hoc wireless workgroup, set the same wireless channel and SSID to match with the computer's configuration.",
"Click ",
" to display the available wireless networks, so that you can easily connect to one of the listed wireless networks.",
": Select the type of wireless communication for the camera.",
": Select the appropriate channel from the pull-down list.",
": Select the authentication method to secure the camera from being used by unauthorized user.",
"- Open: The default setting of Authentication mode, which communicates the key across the network.",
"- Shared-key: Allow communication only with other devices with identical WEP settings.",
"- WPA-PSK/WPA2-PSK: Specially designed for the users who do not have access to network authentication servers. The user has to manually enter the starting password in their access point or gateway, as well as in each PC on the wireless network.",
"Please confirm the configuration you have set up.",
"When you confirm the settings, click ",
" to finish the wizard and reboot the camera. Otherwise, click ",
" to go back to the previous step(s) and change the settings; or click ",
" to end the wizard and discard the changes.",
"Please note that the camera's IP Address will be updated if you changed the IP setting. This may cause the camera to lose the image screen. If this happens, use the supplied IP Finder software application to locate the camera's IP Address. Then, connect to the camera to resume the image screen.",
"Camera is rebooting. Please wait 30 seconds."
);
var popup_msg = new Array(
"Speaker is occupied. Please try again later",
"Open system microphone failed",
"Microfono desactivado",
"Error de Red",
"Error desconocido",
"Camera microphone is occupied",
"Open system sound failed",
"Camera microphone is disabled",
"Discard changes",
"Admin password left blank",
"Password not match",
"shouldn't be left blank",
"exceeds range",
"not a legal number",
"'0.0.0.0' is a reserved address",
"'255.255.255.255' is a reserved address",
"WEP key should not be empty",
"WEP Key should be ",
" characters long",
"Should only input ASCII code",
"WPA Key should be 8-63 characters long in ASCII or 64 in Hexadecimal",
"Should only input Hexadecimal number [a-f],[A-F],[0-9]",
"This should only contains [a-f],[A-F],[0-9] ",
"This should only contains ascii code",
"not equal to",
"Username in use",
"Testing",
"Are you sure to delete this user?",
"'admin' is reserved",
"Do you want to reboot the device to let the values take effect",
"rule is already set",
"Are you sure to delete this rule?",
"cannot contain space",
"Hour should be between 0-23",
"Minute should be between 0-59",
"Start time should be before end time",
"please select a profile first",
"please select a time interval first",
"This name is already in use",
"Name length should be between 1-16",
"'always' is a pre-defined schedule and cannot be modified",
"Are you sure to delete profile",
"Please enter a profile name",
"is not an positive number",
"should be filled",
"User list full",
"Are you sure to delete this user?",
"The ActiveX control not installed.",
"Time identical",
"Please select a file first",
"Firmware update failed!",
"Firmware update success!",
"Please wait 30 seconds for reboot!",
"Reboot failed!",
"Firmware update is processing. Please reboot later.",
"Device was factory reset!",
"Configuration restore failed!",
"Configuration restore success!!",
"Test Failed!!",
"Storage full!",
"Resolution or frame rate changed. Recording stops.",
"Source video format changed. Recording stops.",
"File access error!",
"no elements",
"This should only contains [a-z],[A-Z],[0-9] "
);
var sw_msg_0 = 0;
var sw_msg_1 = 1;
var sw_msg_2 = 2;
var sw_msg_3 = 3;
var sw_msg_4 = 4;
var sw_msg_5 = 5;
var sw_msg_6 = 6;
var sw_msg_7 = 7;
var sw_msg_8 = 8;
var sw_msg_9 = 9;
var sw_msg_10 = 10;
var sw_msg_11 = 11;
var sw_msg_12 = 12;
var sw_msg_13 = 13;
var sw_msg_14 = 14;
var sw_msg_15 = 15;
var sw_msg_16 = 16;
var sw_msg_17 = 17;
var sw_msg_18 = 18;
var sw_msg_19 = 19;
var sw_msg_20 = 20;
var sw_msg_21 = 21;
var sw_msg_22 = 22;
var sw_msg_23 = 23;
var sw_msg_24 = 24;
var sw_msg_25 = 25;
var sw_msg_26 = 26;
var sw_msg_27 = 27;
var sw_msg_28 = 28;
var sw_msg_29 = 29;
var sw_msg_30 = 30;
var sw_msg_31 = 31;
var sw_msg_32 = 32;
var sw_msg_33 = 33;
						  
var popup_msg_0 = 0;
var popup_msg_1 = 1;
var popup_msg_2 = 2;
var popup_msg_3 = 3;
var popup_msg_4 = 4;
var popup_msg_5 = 5;
var popup_msg_6 = 6;
var popup_msg_7 = 7;
var popup_msg_8 = 8;
var popup_msg_9 = 9;
var popup_msg_10 = 10;
var popup_msg_11 = 11;
var popup_msg_12 = 12;
var popup_msg_13 = 13;
var popup_msg_14 = 14;
var popup_msg_15 = 15;
var popup_msg_16 = 16;
var popup_msg_17 = 17;
var popup_msg_18 = 18;
var popup_msg_19 = 19;
var popup_msg_20 = 20;
var popup_msg_21 = 21;
var popup_msg_22 = 22;
var popup_msg_23 = 23;
var popup_msg_24 = 24;
var popup_msg_25 = 25;
var popup_msg_26 = 26;
var popup_msg_27 = 27;
var popup_msg_28 = 28;
var popup_msg_29 = 29;
var popup_msg_30 = 30;
var popup_msg_31 = 31;
var popup_msg_32 = 32;
var popup_msg_33 = 33;
var popup_msg_34 = 34;
var popup_msg_35 = 35;
var popup_msg_36 = 36;
var popup_msg_37 = 37;
var popup_msg_38 = 38;
var popup_msg_39 = 39;
var popup_msg_40 = 40;
var popup_msg_41 = 41;
var popup_msg_42 = 42;
var popup_msg_43 = 43;
var popup_msg_44 = 44;
var popup_msg_45 = 45;
var popup_msg_46 = 46;
var popup_msg_47 = 47;
var popup_msg_48 = 48;
var popup_msg_49 = 49;
var popup_msg_50 = 50;
var popup_msg_51 = 51;
var popup_msg_52 = 52;
var popup_msg_53 = 53;
var popup_msg_54 = 54;
var popup_msg_55 = 55;
var popup_msg_56 = 56;
var popup_msg_57 = 57;
var popup_msg_58 = 58;
var popup_msg_59 = 59;
var popup_msg_60 = 60;
var popup_msg_61 = 61;
var popup_msg_62 = 62;
var popup_msg_63 = 63;
var popup_msg_64 = 64;
