var item_name = new Array(
"Compresion",
"MPEG4",
"MJPEG",
"Grabar",
"Capturar",
"Examinar",
"Hablar",
"Escuchar",
"Mode Noche",
"Smart Wizard",
"Camera Setting",
"Camera Name",
"Fecha",
"Admin Password",
"Confirm Password",
"Next >",
"Cancel",
"IP Setting",
"DHCP",
"Static IP",
"IP",
"Subnet Mask",
"Default Gateway",
"Primary DNS",
"Secondary DNS",
"PPPoE",
"User Name",
"Password",
"< Prev",
"Email Setting",
"SMTP Server Address",
"Sender Email Address",
"Authentication Mode",
"Sender User Name",
"Sender Password",
"Receiver #1 Email Address",
"Receiver #2 Email Address",
"Wireless Networking",
"Network ID(SSID)",
"Site Survey",
"Wireless Mode",
"Infrastructure",
"Ad-Hoc",
"Channel",
"Authentication",
"Encryption",
"None",
"WEP",
"TKIP",
"AES",
"Format",
"ASCII",
"HEX",
"Key Length",
"64 bits",
"128 bits",
"WEP Key 1",
"WEP Key 2",
"WEP Key 3",
"WEP Key 4",
"Pre-Shared Key",
"Confirm Settings",
"IP MODE",
"IP Address",
"Primary DNS Address",
"Secondary DNS address",
"ESSID",
"Connection",
"Apply",
"Basic",
"System",
"Date & Time",
"User",
"Network",
"IP Filter",
"Wireless",
"Video/Audio",
"Camera",
"Video",
"Audio",
"Event Server",
"FTP",
"Email",
"NetStorage",
"Motion Detect",
"Event Config",
"General",
"Schedule Profile",
"Motion Trigger",
"Schedule Trigger",
"Tools",
"USB",
"Information",
"Device Info",
"System Log",
"Indication LED",
"Indication LED control",
"Normal",
"OFF",
"TimeZone",
"Synchronize with PC",
"Synchronize with NTP Server",
"NTP Server Address",
"Update Interval",
"hours",
"Manual",
"Date",
"Time",
"Administrator",
"Modify",
"General User",
"UserList",
"Add/Modify",
"Delete",
"Guest",
"DDNS Setting",
"Enable",
"Provider",
"Host Name",
"UPnP",
"Ports Number",
"HTTP Port",
"(default: 80)",
"RTSP Port",
"(default: 554)",
"Start IP Address",
"End IP Address",
"Add",
"Deny IP List",
"Wireless Setting",
"Video & Audio",
"Image Setting",
"Brightness",
"Contrast",
"Saturation",
"(0~100)",
"Default",
"Mirror",
"Vertical",
"Horizontal",
"Light Frequency",
"50HZ",
"60Hz",
"Outdoor",
"Overlay Setting",
"Include Date & Time",
"Enable Opaque",
"Video Resolution",
"Video Quality",
"Frame Rate",
"Auto",
"Limited to ",
"fps",
"3GPP",
"Disable",
"3GPP Without Audio",
"3Gpp With Audio",
"Camera Microphone In",
"Camera Speaker Out",
"Volume",
"Event Server",
"Event Server Setting",
"Host Address",
"Port Number",
"Directory Path",
"Passive mode",
"Test",
"Network Storage",
"Samba Server Address",
"Share",
"Path",
"Anonymous",
"Split By",
"File Size ",
"(MB)",
"Recording Time ",
"(Minutes)",
"When Disk Full",
"Stop Recording",
"Recycle - Delete Oldest Folder",
"Motion Detection",
"Detection Configuration",
"Event Configuration",
"General Setting",
"Snapshot/Recording Subfolder",
"Network Storage Recording Time Per Event",
"secs",
"Arrange Schedule Profile",
"Motion Detect Trigger",
"(*Please set the corresponding server setting first)",
"Action",
"Send Email",
"FTP Upload",
"Record to Network Storage",
"Save Image to USB",
"Schedule Trigger",
"Email Schedule",
"Interval",
"FTP Schedule",
"Network Storage Schedule",
"System Tools",
"Factory Reset",
"Factory reset will restore all the setting ",
"System Reboot",
"System will be rebooted ",
"Reboot",
"Configuration",
"Backup",
"Get the backup file",
"Restore",
"Update Firmware",
"Current Firmware Version",
"Select the firmware",
"Update",
"USB Setting",
"USB Dismount",
"Safely dismount USB",
"Dismount",
"USB Information",
"Total space",
"Free space",
"System Information",
"Device Information",
"Firmware Version",
"MPEG4 Resolution",
"MJPEG Resolution",
"3GPP Enable",
"Microphone In",
"Speaker Out",
"UPnP Enable",
"Logs",
"Logs table",
"Refresh",
"Event",
"Detener...",
"Alarm Sent",
"Manual Alarm",
"Grabacion OK",
"Grabacion fallo!",
"Hablando...",
"Escuchando...",
"Buscando",
"siempre",
"camera 1",
"meeting room 1",
"MAC",
"MODE",
"Privacy",
"Signal",
"prev",
"Date and Time",
"SMTP",
"Profile Name",
"Weekdays",
"Sun",
"Mon",
"Tue",
"Wed",
"Thu",
"Fri",
"Sat",
"Time List",
"Copy this to all weekdays",
"Delete this from all weekdays",
"Start Time",
"End Time",
"Save",
"Reset",
"MAC Address",
"User Name",
"Password",
"User Name",
"Password",
"Error",
"Test server"
);
						  
var _COMPRESSION = 0;
var _MPEG4 = 1;
var _MJPEG = 2;
var _MANUAL_RECORD = 3;
var _SNAPSHOT = 4;
var _BROWSE = 5;
var _TALK = 6;
var _LISTEN = 7;
var _NIGHTMODE = 8;
var _SMART_WIZARD = 9;
var _CAM_SETTING = 10;
var _CAM_NAME = 11;
var _LOCATION = 12;
var _ADMIN_PWD = 13;
var _CONFIRM_PWD = 14;
var _NAXT = 15;
var _CANCEL = 16;
var _IP_SETTING = 17;
var _DHCP = 18;
var _STATIC_IP = 19;
var _IP = 20;
var _SUBNET_MASK = 21;
var _DEFAULT_GW = 22;
var _PRI_DNS = 23;
var _SEC_DNS = 24;
var _PPPOE = 25;
var _USER_NAME = 26;
var _PASSWORD = 27;
var _PREV = 28;
var _EMAIL_SETTING = 29;
var _SMTP_SERVER = 30;
var _SENDER_EMAIL = 31;
var _AUTH_MODE = 32;
var _SENDER_USER = 33;
var _SENDER_PWD = 34;
var _RECEIVER_1 = 35;
var _RECEIVER_2 = 36;
var _WIRELESS_NET = 37;
var _NETWORK_ID = 38;
var _SITE_SURVEY = 39;
var _WIRELESS_MODE = 40;
var _INFRASTRUC = 41;
var _AD_HOC = 42;
var _CHANNEL = 43;
var _AUTH = 44;
var _ENCRYPTION = 45;
var _NONE = 46;
var _WEP = 47;
var _TKIP = 48;
var _AES = 49;
var _FORMAT = 50;
var _ASCII = 51;
var _HEX = 52;
var _KEY_LENGTH = 53;
var _BITS_64 = 54;
var _BITS_128 = 55;
var _WEP_K1 = 56;
var _WEP_K2 = 57;
var _WEP_K3 = 58;
var _WEP_K4 = 59;
var _PRE_SHAR_KEY = 60;
var _CONFIRM_SETTING = 61;
var _IP_MODE = 62;
var _IP_ADDR = 63;
var _PRI_DNS_ADDR = 64;
var _SEC_DNS_ADDR = 65;
var _ESSID = 66;
var _CONNECTION = 67;
var _APPLY = 68;
var _BASIC = 69;
var _SYSTEM = 70;
var _DATE_TIME = 71;
var _USER = 72;
var _NETWORK = 73;
var _IP_FILTER = 74;
var _WIRELESS = 75;
var _VIDEO_AUDIO = 76;
var _CAMERA = 77;
var _VIDEO = 78;
var _AUDIO = 79;
var _EVENT_SERVER = 80;
var _FTP = 81;
var _EMAIL = 82;
var _NETSTORAGE = 83;
var _MOTION_DET = 84;
var _EVENT_CONFIG = 85;
var _GENERAL = 86;
var _SCHEDULE_PROF = 87;
var _MOTION_TRIG = 88;
var _SCHEDULE_TRIG = 89;
var _TOOLS = 90;
var _USB = 91;
var _INFORMATION = 92;
var _DEV_INFO = 93;
var _SYS_LOG = 94;
var _INDI_LED = 95;
var _INDI_LED_CTL = 96;
var _NORMAL = 97;
var _OFF = 98;
var _TIMEZONE = 99;
var _SYNC_PC = 100;
var _SYNC_NTP = 101;
var _NTP_SERVER = 102;
var _UPDATE_INTVL = 103;
var _HOURS = 104;
var _MANUAL = 105;
var _DATE = 106;
var _TIME = 107;
var _ADMIN = 108;
var _MODIFY = 109;
var _GEN_USER = 110;
var _USERLIST = 111;
var _ADD_MOD = 112;
var _DELETE = 113;
var _GUEST = 114;
var _DDNS_SETTING = 115;
var _ENABLE = 116;
var _PROVIDER = 117;
var _HOST_NAME = 118;
var _UPNP = 119;
var _PORTS_NUM = 120;
var _HTTP_PORT = 121;
var _DEF_80 = 122;
var _RTSP_PORT = 123;
var _DEF_554 = 124;
var _START_IP = 125;
var _END_IP = 126;
var _ADD = 127;
var _DENY_IP_LIST = 128;
var _WIRE_SETTING = 129;
var _VIDEO_N_AUDIO = 130;
var _IMAGE_SETTING = 131;
var _BRIGHTNESS = 132;
var _CONTRAST = 133;
var _SATURATION = 134;
var _RANGE = 135;
var _DEFAULT = 136;
var _MIRROR = 137;
var _VERTICAL = 138;
var _HORIZONTAL = 139;
var _LIGHT_FREQ = 140;
var _50HZ = 141;
var _60HZ = 142;
var _OUTDOOR = 143;
var _OLAY_SETTING = 144;
var _INCLUDE_DATE_TIME = 145
var _ENABLE_OPQ = 146;
var _V_RESOLUTION = 147;
var _V_QUALITY = 148;
var _FRAME_RATE = 149;
var _AUTO = 150;
var _LIMITE_TO = 151;
var _FPS = 152;
var _3GPP = 153;
var _DISABLE = 154;
var _WITHOUT_AUDIO = 155;
var _WITH_AUDIO = 156;
var _CAM_MIC_IN = 157;
var _CAM_SPK_OUT = 158;
var _VOLUME = 159;
var _EVENT_SERVER = 160;
var _EVENT_SERVER_SET = 161;
var _HOST_ADDR = 162;
var _PORT_NUM = 163;
var _DIRECT_PATH = 164;
var _PASS_MODE = 165;
var _TEST = 166;
var _NET_STORAGE = 167;
var _SAMBA_SERVER = 168;
var _SHARE = 169;
var _PATH = 170;
var _ANONYMOUS = 171;
var _SPLIT_BY = 172;
var _FILE_SIZE = 173;
var _MB = 174;
var _RECORD_TIME = 175;
var _MINUTE = 176;
var _DISK_FULL = 177;
var _STOP_RECORDING = 178;
var _RECYCLE = 179;
var _MOTION_DETECTION = 180;
var _DETECT_CONFIG = 181;
var _EVENT_CONFIGURATION = 182;
var _GEN_SETTING = 183;
var _SUBFOLDER = 184;
var _TIME_PER_EVENT = 185;
var _SECS = 186;
var _ARRANGE_SCH = 187;
var _MOTION_DET_TRIG = 188;
var _PLEASE_SET = 189;
var _ACTION = 190;
var _SEND_EMAIL = 191;
var _FTP_UPLOAD = 192;
var _RECORD_TO_NET = 193;
var _IMG_TO_USB = 194;
var _SCH_TRIG = 195;
var _EMAIL_SCHEDULE = 196;
var _INTERVAL = 197;
var _FTP_SCHEDULE = 198;
var _STORAGE_SCHEDULE = 199;
var _SYS_TOOLS = 200;
var _FACT_RESET = 201;
var _RESTOR_SET = 202;
var _SYS_REBOOT = 203;
var _SYS_REBOOTED = 204;
var _REBOOT = 205;
var _CONFIGURATION = 206;
var _BACKUP = 207;
var _GET_BACKUP_FILE = 208;
var _RESTORE = 209;
var _UPDATE_FW = 210;
var _CURRENT_FW_VER = 211;
var _SELECT_FW = 212;
var _UPDATE = 213;
var _USB_SETTING = 214;
var _USB_DISMOUNT = 215;
var _DISMOUNT_USB = 216;
var _DISMOUNT = 217;
var _USB_INFO = 218;
var _TOTAL_SPACE = 219;
var _FREE_SPACE = 220;
var _SYS_INFO = 221;
var _DEV_INFORMATION = 222;
var _FW_VER = 223;
var _MP4_RESOL = 224;
var _MJP_RESOL = 225;
var _ENABLE_3GPP = 226;
var _MIC_IN = 227;
var _SPK_OUT = 228;
var _UPNP_ENABLE = 229;
var _LOGS = 230;
var _LOGS_TABLE = 231;
var _REFRESH = 232;
var _EVENT = 233;
var _STOP_RECORD = 234;
var _ALARM_SENT = 235;
var _MANUAL_ALARM = 236;
var _SAVE_OK = 237;
var _SAVE_FAIL = 238;
var _TALKING = 239;
var _LISTENING = 240;
var _SEARCH = 241;
var _ALWAYS = 242;
var _CAM_1 = 243;
var _MEET_ROOM = 244;
var _MAC = 245;
var _MODE = 246;
var _PRIVACY = 247;
var _SIGNAL = 248;
var _prev_1 = 249;
var _DATE_N_TIME = 250;
var _SMTP = 251;
var _PROFILE_NAME = 252;
var _WEEKDAYS = 253;
var _SUN = 254;
var _MON = 255;
var _TUE = 256;
var _WED = 257;
var _THU = 258;
var _FRI = 259;
var _SAT = 260;
var _TIME_LIST = 261;
var _COPY_THIS = 262;
var _DELETE_THIS = 263;
var _START_TIME = 264;
var _END_TIME = 265;
var _SAVE = 266;
var _reset = 267;
var _MAC_ADDR = 268;
var _PPPOE_USER = 269;
var _PPPOE_PWD = 270;
var _DDNS_USER = 271;
var _DDNS_PWD = 272;
var _ERROR = 273;
var _TEST_SERVER = 274;
