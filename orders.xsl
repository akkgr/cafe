<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
    <!-- Θα παραχθεί ένα έγγραφο HTML -->
    <xsl:output method = "html"></xsl:output> 
    <xsl:template match="/" >
        <!-- Έλενγξε αν υπάρχουν εγγραφές -->
        <xsl:if test="count(/orders/order) &gt; 0"> 
            <p align="center">Σύνολο Παραγγελιών:
                <b>
                    <!-- Εμφάνισε με έντονα γράμματα το πλήθος των παραγγελιών για το χρονικό διάστημα που επέλεξε ο χρήστης  -->
                    <xsl:value-of select="count(/orders/order)"/> 
                </b>
            </p>
            <!-- Δημιούργησε τις επικεφαλίδες του πίνακα HTML που θα απεικονίσει τις παραγγελίες  -->    
            <table align="center" width="80%" style="border:1px solid;" >
                <tr>
                    <th style="border:1px solid;" align="justify">Όνομα Είδους</th>
                    <th style="border:1px solid;" align="center">Τιμή</th>
                    <th style="border:1px solid;" align="center">Ποσότητα</th>
                    <th style="border:1px solid;" align="justify">Σερβιτόρος</th>
                </tr>
                 <!-- Iteration για τη δημιουργία των γραμμών του πίνακα σε καθεμία από τις οποίες θα περιέχεται μία παραγγελία  -->
                <xsl:for-each select="orders/order">
                    <tr>
                        <td style="border:1px solid;" valign="top" align="justify">
                            <font>
                                <xsl:value-of select="name" />
                            </font>
                        </td>
                        <td style="border:1px solid;" valign="top" align="center" >
                            <font >
                                <xsl:value-of select="price"/>
                            </font>
                        </td>
                        <td style="border:1px solid;" valign="top" align="center" >
                            <font>
                                <xsl:value-of select="quantity"/>
                            </font>
                        </td>
                        <td style="border:1px solid;" valign="top" align="justify">
                            <font>
                                <xsl:value-of select="waiter" />
                            </font>
                        </td>
                    </tr>
                </xsl:for-each>
            </table>
            <br/>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>