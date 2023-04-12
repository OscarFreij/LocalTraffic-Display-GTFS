/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `agency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agency` (
  `agency_id` varchar(17) NOT NULL COMMENT 'Identifies a transit brand which is often synonymous with a transit agency. Note that in some cases, such as when a single agency operates multiple separate services, agencies and brands are distinct. This document uses the term "agency" in place of "brand". A dataset may contain data from multiple agencies. This field is required when the dataset contains data for multiple transit agencies, otherwise it is optional.\r\n',
  `agency_name` text NOT NULL COMMENT 'Full name of the transit agency.\r\n',
  `agency_url` text NOT NULL COMMENT 'URL of the transit agency.',
  `agency_timezone` text NOT NULL COMMENT 'Timezone where the transit agency is located. If multiple agencies are specified in the dataset, each must have the same agency_timezone.',
  `agency_lang` text NOT NULL COMMENT '	Primary language used by this transit agency. This field helps GTFS consumers choose capitalization rules and other language-specific settings for the dataset.',
  `agency_fare_url` text NOT NULL COMMENT 'URL of a web page that allows a rider to purchase tickets or other fare instruments for that agency online.',
  PRIMARY KEY (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attributions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributions` (
  `trip_id` varchar(24) NOT NULL COMMENT '	This field functions in the same way as agency_id, except the attribution applies to a trip. Multiple attributions can apply to the same trip.',
  `organization_name` text NOT NULL COMMENT 'The name of the organization that the dataset is attributed to.',
  `is_operator` text NOT NULL COMMENT 'Functions in the same way as is_producer, except the role of the organization is operator.',
  PRIMARY KEY (`trip_id`),
  KEY `trip_id` (`trip_id`),
  CONSTRAINT `attributions_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`trip_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `service_id` int(11) NOT NULL COMMENT 'Indicates if arrival and departure times for a stop are strictly adhered to by the vehicle or if they are instead approximate and/or interpolated times. This field allows a GTFS producer to provide interpolated stop-times, while indicating that the times are approximate. Valid options are:\r\n\r\n0 - Times are considered approximate.\r\n1 or empty - Times are considered exact.',
  `monday` text NOT NULL COMMENT 'Indicates whether the service operates on all Mondays in the date range specified by the start_date and end_date fields. Note that exceptions for particular dates may be listed in calendar_dates.txt. Valid options are:\r\n\r\n1 - Service is available for all Mondays in the date range.\r\n0 - Service is not available for Mondays in the date range.',
  `tuesday` text NOT NULL COMMENT 'Functions in the same way as monday except applies to Tuesdays',
  `wednesday` text NOT NULL COMMENT 'Functions in the same way as monday except applies to Tuesdays',
  `thursday` text NOT NULL COMMENT '	Functions in the same way as monday except applies to Thursdays',
  `friday` text NOT NULL COMMENT 'Functions in the same way as monday except applies to Fridays',
  `saturday` text NOT NULL COMMENT 'Functions in the same way as monday except applies to Fridays',
  `sunday` text NOT NULL COMMENT 'Functions in the same way as monday except applies to Sundays.',
  `start_date` text NOT NULL COMMENT 'Start service day for the service interval.',
  `end_date` text NOT NULL COMMENT 'End service day for the service interval. This service day is included in the interval.',
  PRIMARY KEY (`service_id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `calendar_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_dates` (
  `service_id` int(11) NOT NULL COMMENT 'Identifies a set of dates when a service exception occurs for one or more routes. Each (service_id, date) pair can only appear once in calendar_dates.txt if using calendar.txt and calendar_dates.txt in conjunction. If a service_id value appears in both calendar.txt and calendar_dates.txt, the information in calendar_dates.txt modifies the service information specified in calendar.txt.',
  `date` text NOT NULL COMMENT 'Date when service exception occurs.',
  `exception_type` text NOT NULL COMMENT 'End service day for the service interval. This service day is included in the interval.',
  KEY `service_id` (`service_id`),
  CONSTRAINT `calendar_dates_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `calendar` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `feed_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed_info` (
  `feed_id` text NOT NULL,
  `feed_publisher_name` text NOT NULL COMMENT '	URL of the dataset publishing organization''s website. This may be the same as one of the agency.agency_url values.',
  `feed_publisher_url` text NOT NULL COMMENT '	URL of the dataset publishing organization''s website. This may be the same as one of the agency.agency_url values.',
  `feed_lang` text NOT NULL COMMENT '	URL of the dataset publishing organization''s website. This may be the same as one of the agency.agency_url values.',
  `feed_version` text NOT NULL COMMENT 'String that indicates the current version of their GTFS dataset. GTFS-consuming applications can display this value to help dataset publishers determine whether the latest dataset has been incorporated.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routes` (
  `route_id` varchar(24) NOT NULL COMMENT '	Identifies a route.',
  `agency_id` varchar(17) NOT NULL COMMENT 'Agency for the specified route. This field is required when the dataset provides data for routes from more than one agency in agency.txt, otherwise it is optional.',
  `route_short_name` text NOT NULL COMMENT 'Short name of a route. This will often be a short, abstract identifier like "32", "100X", or "Green" that riders use to identify a route, but which doesn''t give any indication of what places the route serves. Either route_short_name or route_long_name must be specified, or potentially both if appropriate.',
  `route_long_name` text NOT NULL COMMENT 'Full name of a route. This name is generally more descriptive than the route_short_name and often includes the route''s destination or stop. Either route_short_name or route_long_name must be specified, or potentially both if appropriate.',
  `route_type` text NOT NULL COMMENT 'Indicates the type of transportation used on a route. Valid options are:\r\n\r\n0 - Tram, Streetcar, Light rail. Any light rail or street level system within a metropolitan area.\r\n1 - Subway, Metro. Any underground rail system within a metropolitan area.\r\n2 - Rail. Used for intercity or long-distance travel.\r\n3 - Bus. Used for short- and long-distance bus routes.\r\n4 - Ferry. Used for short- and long-distance boat service.\r\n5 - Cable tram. Used for street-level rail cars where the cable runs beneath the vehicle, e.g., cable car in San Francisco.\r\n6 - Aerial lift, suspended cable car (e.g., gondola lift, aerial tramway). Cable transport where cabins, cars, gondolas or open chairs are suspended by means of one or more cables.\r\n7 - Funicular. Any rail system designed for steep inclines.\r\n11 - Trolleybus. Electric buses that draw power from overhead wires using poles.\r\n12 - Monorail. Railway in which the track consists of a single rail or a beam.',
  `route_desc` text NOT NULL COMMENT '	Description of a route that provides useful, quality information. Do not simply duplicate the name of the route.\r\nExample: "A" trains operate between Inwood-207 St, Manhattan and Far Rockaway-Mott Avenue, Queens at all times. Also from about 6AM until about midnight, additional "A" trains operate between Inwood-207 St and Lefferts Boulevard (trains typically alternate between Lefferts Blvd and Far Rockaway).',
  PRIMARY KEY (`route_id`),
  KEY `agency_id` (`agency_id`),
  CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`agency_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `serviceAlerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serviceAlerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataRetrivalId` int(11) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`content`)),
  `creationTime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `dataRetrivalId` (`dataRetrivalId`),
  CONSTRAINT `serviceAlerts_ibfk_1` FOREIGN KEY (`dataRetrivalId`) REFERENCES `workerDataRetrievals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shapes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shapes` (
  `shape_id` varchar(24) NOT NULL COMMENT 'Identifies a shape.',
  `shape_pt_lat` text NOT NULL COMMENT 'Latitude of a shape point. Each record in shapes.txt represents a shape point used to define the shape.',
  `shape_pt_lon` text NOT NULL COMMENT 'Longitude of a shape point.',
  `shape_pt_sequence` text NOT NULL COMMENT 'Sequence in which the shape points connect to form the shape. Values must increase along the trip but do not need to be consecutive.\r\nExample: If the shape "A_shp" has three points in its definition, the shapes.txt file might contain these records to define the shape:\r\nshape_id,shape_pt_lat,shape_pt_lon,shape_pt_sequence\r\nA_shp,37.61956,-122.48161,0\r\nA_shp,37.64430,-122.41070,6\r\nA_shp,37.65863,-122.30839,11',
  `shape_dist_traveled` text NOT NULL COMMENT 'Actual distance traveled along the shape from the first shape point to the point specified in this record. Used by trip planners to show the correct portion of the shape on a map. Values must increase along with shape_pt_sequence; they cannot be used to show reverse travel along a route. Distance units must be consistent with those used in stop_times.txt.\r\nExample: If a bus travels along the three points defined above for A_shp, the additional shape_dist_traveled values (shown here in kilometers) would look like this:\r\nshape_id,shape_pt_lat,shape_pt_lon,shape_pt_sequence,shape_dist_traveled\r\nA_shp,37.61956,-122.48161,0,0\r\nA_shp,37.64430,-122.41070,6,6.8310\r\nA_shp,37.65863,-122.30839,11,15.8765',
  KEY `shape_id` (`shape_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `stop_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stop_times` (
  `trip_id` varchar(24) NOT NULL COMMENT 'Identifies a trip.\r\n',
  `arrival_time` text NOT NULL COMMENT 'Arrival time at a specific stop for a specific trip on a route. If there are not separate times for arrival and departure at a stop, enter the same value for arrival_time and departure_time. For times occurring after midnight on the service day, enter the time as a value greater than 24:00:00 in HH:MM:SS local time for the day on which the trip schedule begins.\r\n\r\nScheduled stops where the vehicle strictly adheres to the specified arrival and departure times are timepoints. If this stop is not a timepoint, it is recommended to provide an estimated or interpolated time. If this is not available, arrival_time can be left empty. Further, indicate that interpolated times are provided with timepoint=0. If interpolated times are indicated with timepoint=0, then time points must be indicated with timepoint=1. Provide arrival times for all stops that are time points. An arrival time must be specified for the first and the last stop in a trip.',
  `departure_time` text NOT NULL COMMENT 'Departure time from a specific stop for a specific trip on a route. For times occurring after midnight on the service day, enter the time as a value greater than 24:00:00 in HH:MM:SS local time for the day on which the trip schedule begins. If there are not separate times for arrival and departure at a stop, enter the same value for arrival_time and departure_time. See the arrival_time description for more details about using timepoints correctly.\r\n\r\nThe departure_time field should specify time values whenever possible, including non-binding estimated or interpolated times between timepoints.',
  `stop_id` varchar(24) NOT NULL COMMENT 'Identifies the serviced stop. All stops serviced during a trip must have a record in stop_times.txt. Referenced locations must be stops, not stations or station entrances. A stop may be serviced multiple times in the same trip, and multiple trips and routes may service the same stop.',
  `stop_sequence` text NOT NULL COMMENT 'Identifies the serviced stop. All stops serviced during a trip must have a record in stop_times.txt. Referenced locations must be stops, not stations or station entrances. A stop may be serviced multiple times in the same trip, and multiple trips and routes may service the same stop.',
  `stop_headsign` text NOT NULL COMMENT 'Identifies the serviced stop. All stops serviced during a trip must have a record in stop_times.txt. Referenced locations must be stops, not stations or station entrances. A stop may be serviced multiple times in the same trip, and multiple trips and routes may service the same stop.',
  `pickup_type` text NOT NULL COMMENT 'Indicates pickup method. Valid options are:\r\n\r\n0 or empty - Regularly scheduled pickup.\r\n1 - No pickup available.\r\n2 - Must phone agency to arrange pickup.\r\n3 - Must coordinate with driver to arrange pickup.',
  `drop_off_type` text NOT NULL COMMENT 'Indicates drop off method. Valid options are:\r\n\r\n0 or empty - Regularly scheduled drop off.\r\n1 - No drop off available.\r\n2 - Must phone agency to arrange drop off.\r\n3 - Must coordinate with driver to arrange drop off.',
  `shape_dist_traveled` text NOT NULL COMMENT 'Actual distance traveled along the associated shape, from the first stop to the stop specified in this record. This field specifies how much of the shape to draw between any two stops during a trip. Must be in the same units used in shapes.txt. Values used for shape_dist_traveled must increase along with stop_sequence; they cannot be used to show reverse travel along a route.\r\nExample: If a bus travels a distance of 5.25 kilometers from the start of the shape to the stop, shape_dist_traveled=5.25.',
  `timepoint` text NOT NULL COMMENT 'Indicates if arrival and departure times for a stop are strictly adhered to by the vehicle or if they are instead approximate and/or interpolated times. This field allows a GTFS producer to provide interpolated stop-times, while indicating that the times are approximate. Valid options are:\r\n\r\n0 - Times are considered approximate.\r\n1 or empty - Times are considered exact.',
  KEY `trip_id` (`trip_id`),
  KEY `stop_id` (`stop_id`),
  CONSTRAINT `stop_times_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`trip_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stop_times_ibfk_2` FOREIGN KEY (`stop_id`) REFERENCES `stops` (`stop_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `stops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stops` (
  `stop_id` varchar(24) NOT NULL COMMENT 'Identifies a stop, station, or station entrance.\r\n\r\nThe term "station entrance" refers to both station entrances and station exits. Stops, stations or station entrances are collectively referred to as locations. Multiple routes may use the same stop.',
  `stop_name` text NOT NULL COMMENT 'Short text or a number that identifies the location for riders. These codes are often used in phone-based transit information systems or printed on signage to make it easier for riders to get information for a particular location. The stop_code can be the same as stop_id if it is public facing. This field should be left empty for locations without a code presented to riders.',
  `stop_lat` text NOT NULL COMMENT 'Latitude of the location.\r\n\r\nConditionally Required:\r\n• Required for locations which are stops (location_type=0), stations (location_type=1) or entrances/exits (location_type=2).\r\n• Optional for locations which are generic nodes (location_type=3) or boarding areas (location_type=4).',
  `stop_lon` text NOT NULL COMMENT '	Longitude of the location.\r\n\r\nConditionally Required:\r\n• Required for locations which are stops (location_type=0), stations (location_type=1) or entrances/exits (location_type=2).\r\n• Optional for locations which are generic nodes (location_type=3) or boarding areas (location_type=4).',
  `location_type` text NOT NULL COMMENT '	Longitude of the location.\r\n\r\nConditionally Required:\r\n• Required for locations which are stops (location_type=0), stations (location_type=1) or entrances/exits (location_type=2).\r\n• Optional for locations which are generic nodes (location_type=3) or boarding areas (location_type=4).',
  `parent_station` text NOT NULL COMMENT 'Defines hierarchy between the different locations defined in stops.txt. It contains the ID of the parent location, as followed:\r\n• Stop/platform (location_type=0): the parent_station field contains the ID of a station.\r\n• Station (location_type=1): this field must be empty.\r\n• Entrance/exit (location_type=2) or generic node (location_type=3): the parent_station field contains the ID of a station (location_type=1)\r\n• Boarding Area (location_type=4): the parent_station field contains ID of a platform.\r\n\r\nConditionally Required:\r\n• Required for locations which are entrances (location_type=2), generic nodes (location_type=3) or boarding areas (location_type=4).\r\n• Optional for stops/platforms (location_type=0).\r\n• Forbidden for stations (location_type=1).',
  `platform_code` text NOT NULL COMMENT '	Platform identifier for a platform stop (a stop belonging to a station). This should be just the platform identifier (eg. G or 3). Words like "platform" or "track" (or the feed’s language-specific equivalent) should not be included. This allows feed consumers to more easily internationalize and localize the platform identifier into other languages.',
  PRIMARY KEY (`stop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transfers` (
  `from_stop_id` varchar(24) NOT NULL COMMENT 'Actual distance traveled along the shape from the first shape point to the point specified in this record. Used by trip planners to show the correct portion of the shape on a map. Values must increase along with shape_pt_sequence; they cannot be used to show reverse travel along a route. Distance units must be consistent with those used in stop_times.txt.\r\nExample: If a bus travels along the three points defined above for A_shp, the additional shape_dist_traveled values (shown here in kilometers) would look like this:\r\nshape_id,shape_pt_lat,shape_pt_lon,shape_pt_sequence,shape_dist_traveled\r\nA_shp,37.61956,-122.48161,0,0\r\nA_shp,37.64430,-122.41070,6,6.8310\r\nA_shp,37.65863,-122.30839,11,15.8765',
  `to_stop_id` varchar(24) NOT NULL COMMENT 'Identifies a stop or station where a connection between routes ends. If this field refers to a station, the transfer rule applies to all child stops.',
  `transfer_type` text NOT NULL COMMENT 'Indicates the type of connection for the specified (from_stop_id, to_stop_id) pair. Valid options are:\r\n\r\n0 or empty - Recommended transfer point between routes.\r\n1 - Timed transfer point between two routes. The departing vehicle is expected to wait for the arriving one and leave sufficient time for a rider to transfer between routes.\r\n2 - Transfer requires a minimum amount of time between arrival and departure to ensure a connection. The time required to transfer is specified by min_transfer_time.\r\n3 - Transfers aren''t possible between routes at the location.\r\n4 - Passengers can stay onboard the same vehicle to transfer from one trip to another (an "in-seat transfer").\r\n5 - In-seat transfers aren''t allowed between sequential trips. The passenger must alight from the vehicle and re-board.',
  `min_transfer_time` text NOT NULL COMMENT 'Indicates the type of connection for the specified (from_stop_id, to_stop_id) pair. Valid options are:\r\n\r\n0 or empty - Recommended transfer point between routes.\r\n1 - Timed transfer point between two routes. The departing vehicle is expected to wait for the arriving one and leave sufficient time for a rider to transfer between routes.\r\n2 - Transfer requires a minimum amount of time between arrival and departure to ensure a connection. The time required to transfer is specified by min_transfer_time.\r\n3 - Transfers aren''t possible between routes at the location.\r\n4 - Passengers can stay onboard the same vehicle to transfer from one trip to another (an "in-seat transfer").\r\n5 - In-seat transfers aren''t allowed between sequential trips. The passenger must alight from the vehicle and re-board.',
  `from_trip_id` varchar(24) NOT NULL,
  `to_trip_id` varchar(24) NOT NULL,
  KEY `from_trip_id` (`from_trip_id`),
  KEY `to_trip_id` (`to_trip_id`),
  KEY `from_stop_id` (`from_stop_id`,`to_stop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tripUpdates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tripUpdates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataRetrivalId` int(11) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`content`)),
  `creationTime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `dataRetrivalId` (`dataRetrivalId`),
  CONSTRAINT `tripUpdates_ibfk_1` FOREIGN KEY (`dataRetrivalId`) REFERENCES `workerDataRetrievals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trips` (
  `route_id` varchar(24) NOT NULL COMMENT 'Identifies a route.\r\n',
  `service_id` int(11) NOT NULL COMMENT 'Identifies a set of dates when service is available for one or more routes.\r\n',
  `trip_id` varchar(24) NOT NULL COMMENT 'Identifies a trip.\r\n',
  `trip_headsign` text NOT NULL COMMENT 'Text that appears on signage identifying the trip''s destination to riders. Use this field to distinguish between different patterns of service on the same route. If the headsign changes during a trip, trip_headsign can be overridden by specifying values for the stop_times.stop_headsign.\r\n',
  `direction_id` int(11) NOT NULL COMMENT '	Indicates the direction of travel for a trip. This field is not used in routing; it provides a way to separate trips by direction when publishing time tables. Valid options are:\r\n\r\n0 - Travel in one direction (e.g. outbound travel).\r\n1 - Travel in the opposite direction (e.g. inbound travel).',
  `shape_id` varchar(24) NOT NULL COMMENT 'Identifies a geospatial shape that describes the vehicle travel path for a trip.\r\n\r\nConditionally required:\r\nThis field is required if the trip has continuous behavior defined, either at the route level or at the stop time level.\r\nOtherwise, it''s optional.',
  PRIMARY KEY (`trip_id`),
  KEY `service_id` (`service_id`),
  KEY `route_id` (`route_id`),
  KEY `shape_id` (`shape_id`),
  CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `calendar` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `workerDataRetrievals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workerDataRetrievals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scheduleId` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1=Static\r\n2=ServiceAlerts\r\n3=TripUpdates',
  `eTag` text NOT NULL,
  `lastModified` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `scheduleId` (`scheduleId`),
  CONSTRAINT `workerDataRetrievals_ibfk_1` FOREIGN KEY (`scheduleId`) REFERENCES `workerSchedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `workerSchedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workerSchedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '1=Static 2=ServiceAlerts 3=TripUpdates	',
  `startWeekDay` tinyint(4) NOT NULL COMMENT '0-6 = Sun,Mon,Tue,Wed,Thu,Fri,Sat',
  `endWeekDay` tinyint(4) NOT NULL COMMENT '0-6 = Sun,Mon,Tue,Wed,Thu,Fri,Sat',
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `minimumTimeBetweenCalls` int(11) NOT NULL DEFAULT 300 COMMENT 'Minimum amount of seconds since last call. Standard 5 min (300 sec)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

