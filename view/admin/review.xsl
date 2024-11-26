<?xml version="1.0" encoding="UTF-8"?>
<!--SIASHUNFU-->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" indent="yes" />


    <xsl:template match="Reviews">
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                <title>Review Report</title>
            </head>
            <body>
                <h1>Review Report</h1>
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr bgcolor="#d3d3d3">
                        <th>Review ID</th>
                        <th>User Name</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Archived At</th>
                        <th>Admin Reply</th>
                        <th>Reply Date</th>
                    </tr>

                    <xsl:for-each select="Review">
                        <tr>
                            <td><xsl:value-of select="ID" /></td>
                            <td><xsl:value-of select="UserName" /></td>
                            <td><xsl:value-of select="UserReview" /></td>
                            <td><xsl:value-of select="UserRating" /></td>
                            <td>
                                <!-- Display the image only if it exists -->
                                <xsl:choose>
                                    <xsl:when test="UserImage != ''">
                                        <img src="{UserImage}" alt="Review Image" width="100" height="100" />
                                    </xsl:when>
                                    <xsl:otherwise>
                                        No Image
                                    </xsl:otherwise>
                                </xsl:choose>
                            </td>
                            <td><xsl:value-of select="DateTime" /></td>
                            <td><xsl:value-of select="Status" /></td>
                            <td><xsl:value-of select="ArchivedAt" /></td>
                            <td><xsl:value-of select="AdminReply" /></td>
                            <td><xsl:value-of select="ReplyDateTime" /></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
