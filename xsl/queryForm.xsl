<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <form id="queryForm">
      <table class="list">
        <tr>
          <th>Item Category</th>
          <th>Item Type</th>
        </tr>
        <tr>
          <td>
            <select id="itemCategory" size="1">
              <xsl:for-each select="data/map/item_categories/item_category">
                <xsl:element name="option">
                  <xsl:choose>
                    <xsl:when test="category_ID = 3">
                      <xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:when>
                  </xsl:choose>
                  <xsl:attribute name="value">
                    <xsl:value-of select="category_ID" />
                  </xsl:attribute>
                  <xsl:value-of select="category_name" />
                </xsl:element>
              </xsl:for-each>
            </select>
          </td>
          <td>
                <select name="itemType" size="1">
                  <xsl:for-each select="data/map/item_types/item_type">
                    <xsl:if test="category_ID = 1">
                    <option>
                      <xsl:value-of select="type_name" />
                    </option>
                    </xsl:if>
                  </xsl:for-each>
                </select>
          </td>
        </tr>
      </table>
      <input type="submit" name="submit" value="Query" />
    </form>
  </xsl:template>
</xsl:stylesheet>