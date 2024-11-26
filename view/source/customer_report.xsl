<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- Output method as HTML -->
    <xsl:output method="html" indent="yes"/>

    <!-- Template for the whole document -->
    <xsl:template match="/customers">
        <html>
            <head>
                <title>Customer Registration Report</title>
                <style>
                    <style>
                        body {
                        font-family: Arial, sans-serif;
                        background-color: #f9f9f9; /* Light gray background */
                        margin: 0;
                        padding: 20px;
                        }

                        table {
                        width: 100%;
                        border-collapse: collapse;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
                        border-radius: 8px; /* Rounded corners */
                        overflow: hidden; /* Ensure rounded corners apply to the table */
                        background-color: #ffffff; /* White background for the table */
                        }

                        th, td {
                        padding: 12px 15px; /* More padding for better spacing */
                        text-align: left;
                        }

                        th {
                        background-color: #4caf50; /* Green header */
                        color: white; /* White text for header */
                        font-weight: bold; /* Bold font for header */
                        }

                        tr:nth-child(even) {
                        background-color: #f2f2f2; /* Light gray for even rows */
                        }

                        tr:hover {
                        background-color: #e1f5fe; /* Light blue on hover */
                        transition: background-color 0.3s; /* Smooth transition for hover */
                        }

                        td {
                        border-bottom: 1px solid #dddddd; /* Subtle border between rows */
                        }

                        td:last-child {
                        border-bottom: none; /* Remove border from last row */
                        }

                        @media (max-width: 600px) {
                        table {
                        font-size: 14px; /* Slightly smaller font for smaller screens */
                        }
                        }
                    </style>

                </style>
            </head>
            <body>
                <h1>Customer Registration Report</h1>
                <table>
                    <tr>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Username</th> 
                        <th>Gender</th>    
                        <th>Registration Time</th>
                    </tr>
                    <!-- Loop through each customer -->
                    <xsl:for-each select="customer">
                        <tr>
                            <td>
                                <xsl:value-of select="email"/>
                            </td>
                            <td>
                                <xsl:value-of select="phone"/>
                            </td>
                            <td>
                                <xsl:value-of select="username"/>
                            </td> 
                            <td>
                                <xsl:value-of select="gender"/>
                            </td>  
                            <td>
                                <xsl:value-of select="registrationTime"/>
                            </td> 
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
