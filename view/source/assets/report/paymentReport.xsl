<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  
  <xsl:template match="/paymentReport">
    <html>
      <head>
        <title>Payment Report</title>
        <style>
          table {
            width: 100%;
            border-collapse: collapse;
          }
          th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
          }
          th {
            background-color: #f2f2f2;
          }
        </style>
      </head>
      <body>
        <h2>Payment Report</h2>
        <p><strong>Report Date:</strong> <xsl:value-of select="reportDate" /></p>
        <p><strong>Total Transactions:</strong> <xsl:value-of select="totalTransactions" /></p>
        <p><strong>Total Amount:</strong> <xsl:value-of select="totalAmount" /> <xsl:value-of select="totalAmount/@currency" /></p>

        <h3>Payment Details</h3>
        <table>
          <tr>
            <th>Payment ID</th>
            <th>Payment Date</th>
            <th>Customer ID</th>
            <th>Email</th>
            <th>Payment Method</th>
            <th>Amount</th>
            <th>Quantity</th>
          </tr>
          <!-- Loop through each 'payment' element -->
          <xsl:for-each select="payment">
            <tr>
              <td><xsl:value-of select="paymentID" /></td>
              <td><xsl:value-of select="paymentDate" /></td>
              <td><xsl:value-of select="custDetails/custID" /></td>
              <td><xsl:value-of select="custDetails/email" /></td>
              <td><xsl:value-of select="paymentDetails/paymentMethod" /></td>
              <td><xsl:value-of select="paymentDetails/amount" /></td>
              <td><xsl:value-of select="paymentDetails/quantity" /></td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
