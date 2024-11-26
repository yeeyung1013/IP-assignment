<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <!-- @author: Tan Chee Fung -->
    <xsl:param name="noResults" select="'false'"/>
    <xsl:param name="searchQuery" select="''"/>

    <xsl:template match="/">
        <html>
            <head>
                <title>Event Ticket Distribution</title>
                <style>
                    body {
                    font-family: 'Arial', sans-serif;
                    background: linear-gradient(135deg, #f0f4f8, #e0e7ff);
                    margin: 0;
                    padding: 20px;
                    color: #333;
                    }
                    h1 {
                    text-align: center;
                    color: #4a4e69;
                    margin-bottom: 30px;
                    font-size: 2.5em;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
                    }
                    .button {
                    padding: 10px 15px;
                    border: none;
                    border-radius: 5px;
                    background-color: #4a4e69; /* Darker color */
                    color: white;
                    cursor: pointer;
                    margin: 10px 5px;
                    transition: background-color 0.3s, transform 0.2s;
                    font-size: 1em;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    }
                    .button:hover {
                    background-color: #22223b; /* Even darker */
                    transform: translateY(-2px);
                    }
                    form {
                    text-align: center;
                    margin-bottom: 30px;
                    animation: fadeIn 0.5s;
                    }
                    input[type="text"] {
                    padding: 10px;
                    width: 300px;
                    border: 1px solid #4a4e69;
                    border-radius: 5px;
                    transition: border 0.3s;
                    margin-right: 10px;
                    }
                    input[type="text"]:focus {
                    border-color: #22223b;
                    outline: none;
                    }
                    table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
                    background-color: white;
                    transition: transform 0.3s;
                    }
                    th, td {
                    padding: 12px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                    }
                    th {
                    background-color: #6a0572; /* Purple */
                    color: white;
                    }
                    tr:nth-child(even) {
                    background-color: #f0e5ff; /* Light purple */
                    }
                    tr:nth-child(odd) {
                    background-color: #e0e7ff; /* Light blue */
                    }
                    tr:hover {
                    background-color: #d1c4e9; /* Slightly darker on hover */
                    }
                    .no-results {
                    text-align: center;
                    color: #d9534f; /* Red for emphasis */
                    font-size: 1.2em;
                    margin-top: 20px;
                    }
                    .back-button-container {
                    text-align: center;
                    margin: 20px 0;
                    }
                    @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                    }
                </style>
            </head>
            <body>
                <h1>Event Ticket Distribution</h1>

                <!-- Search Form -->
                <form method="post" action="">
                    <input type="text" name="search" value="{searchQuery}" placeholder="Search by Event Name"/>
                    <input type="submit" class="button" value="Search"/>
                    <input type="submit" name="refresh" class="button" value="Refresh"/>
                </form>
                
                <!-- Back Button -->
                <div class="back-button-container">
                    <button class="button" onclick="window.location.href='home.php';">Back</button>
                </div>
                
                <xsl:choose>
                    <xsl:when test="$noResults = 'true'">
                        <p class="no-results">No events found for "<xsl:value-of select="$searchQuery"/>".</p>
                    </xsl:when>
                    <xsl:otherwise>
                        <table>
                            <tr>
                                <th>Event Name</th>
                                <th>Total Seats</th>
                                <th>Standard Tickets</th>
                                <th>VIP Tickets</th>
                                <th>VVIP Tickets</th>
                                <th>Super VIP Tickets</th>
                                <th>Total Standard Price (RM)</th>
                                <th>Total VIP Price (RM)</th>
                                <th>Total VVIP Price (RM)</th>
                                <th>Total Super VIP Price (RM)</th>
                                <th>Expected total Revenue (RM)</th>
                                <th>Free Seats</th>
                                <th>Actions</th>
                            </tr>
                            <xsl:for-each select="EventTicketDistribution/Event">
                                <tr>
                                    <td>
                                        <xsl:value-of select="EventName"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="TotalSeats"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="StandardTickets"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="VIPTickets"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="VVIPTickets"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="SuperVIPTickets"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="TotalStandardPrice"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="TotalVIPPrice"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="TotalVVIPPrice"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="TotalSuperVIPPrice"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="TotalRevenue"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="FreeSeats"/>
                                    </td>
                                    <td>
                                        <a href="ticketDiagram.php?eventName={EventName}&amp;standardTickets={StandardTickets}&amp;vipTickets={VIPTickets}&amp;vvipTickets={VVIPTickets}&amp;superVipTickets={SuperVIPTickets}&amp;freeTickets={FreeSeats}">
                                            <button class="button">View Graph</button>
                                        </a>
                                    </td>
                                </tr>
                            </xsl:for-each>
                        </table>
                    </xsl:otherwise>
                </xsl:choose>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>