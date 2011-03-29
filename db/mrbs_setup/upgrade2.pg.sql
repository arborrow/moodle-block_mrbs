# $Id: upgrade2.pg.sql,v 1.1 2007/04/05 22:25:22 arborrow Exp $

# Add an extra column to the mrbs_repeat table for rep_type 6
ALTER TABLE mrbs_repeat
ADD COLUMN rep_num_weeks smallint DEFAULT 0 NULL;
