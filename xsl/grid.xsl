<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <xsl:call-template name="menu" />
    <form id="grid_form_id">
      <table class="list">
        <tr>
          <th>Item ID</th>
          <th>Mineral</th>
          <th>Price (ISK)</th>
        </tr>
        <xsl:for-each select="data/grid/item">
          <xsl:element name="tr">
            <xsl:attribute name="id">
              <xsl:value-of select="item_ID" />
            </xsl:attribute>
            <td class="item"><xsl:value-of select="item_ID" /></td>
            <td class="item"><xsl:value-of select="item_name" /></td>
            <td class="item">
              <xsl:choose>
                <xsl:when test="item_price">
                  <xsl:value-of select="item_price" />
                </xsl:when>
                <xsl:otherwise>
                  Not Set
                </xsl:otherwise>
              </xsl:choose>
            </td>
            <td>
              <xsl:element name="a">
                <xsl:attribute name="href">#</xsl:attribute>
                <xsl:attribute name="onclick">
                  editId(<xsl:value-of select="item_ID" />, 1)
                </xsl:attribute>
                <u>Edit</u>
              </xsl:element>
            </td>
          </xsl:element>
        </xsl:for-each>
      </table>
      <xsl:call-template name="menu" />
      <xsl:element name="input">
        <xsl:attribute name="type">button</xsl:attribute>
        <xsl:attribute name="id">newQuery</xsl:attribute>
        <xsl:attribute name="value">New Query</xsl:attribute>
        <xsl:attribute name="onclick">
          loadQueryForm()
        </xsl:attribute>
      </xsl:element>
    </form>
  </xsl:template>
  <xsl:template name="menu">
    <xsl:for-each select="data/parameters">
      <table>
        <tr>
          <td class="left">
            Total Items: <xsl:value-of select="item_count" />
          </td>
          <td class="left">
            <xsl:if test="previous_page > 0">
              <xsl:element name="a">
                <xsl:attribute name="href">#</xsl:attribute>
                <xsl:attribute name="onclick">
                  loadGridPage(<xsl:value-of select="previous_page" />,
                    <xsl:value-of select="query_category" />,
                    <xsl:value-of select="query_type" />)
                </xsl:attribute>
                <u>Previous Page</u>
              </xsl:element>
            </xsl:if>
          </td>
          <td class="right">
            Page <xsl:value-of select="returned_page" />
            of <xsl:value-of select="total_pages" />
          </td>
          <td class="right">
            <xsl:if test="next_page > 0">
              <xsl:element name="a">
              <xsl:attribute name="href">#</xsl:attribute>
                <xsl:attribute name="onclick">
                  loadGridPage(<xsl:value-of select="next_page" />,
                  <xsl:value-of select="query_category" />,
                  <xsl:value-of select="query_type" />)
                </xsl:attribute>
                <u>Next Page</u>
              </xsl:element>
            </xsl:if>
          </td>
        </tr>
      </table>
    </xsl:for-each>
  </xsl:template>
</xsl:stylesheet>