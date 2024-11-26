<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/Events">
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            <title>Event Report</title>
        </head>
        <body>
            <h1>Event Report</h1>
            <table>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Start Date</th>
                    <th>Seat</th>
                </tr>
                <xsl:for-each select="Event">
                    <tr>
                        <td><xsl:value-of select="EventID"/></td>
                        <td><xsl:value-of select="EventName"/></td>
                        <td><xsl:value-of select="Description"/></td>
                        <td><xsl:value-of select="Location"/></td>
                        <td><xsl:value-of select="StartDate"/></td>
                        <td><xsl:value-of select="Seat"/></td>
                    </tr>
                </xsl:for-each>
            </table>
        </body>
        </html>
    </xsl:template>

</xsl:stylesheet>