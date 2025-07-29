describe('Cek Fungsi Halaman Welcome', () => {
  it('Cek perilaku sistem jika memasukkan judul tugas akhir yang valid', () => {
    cy.visit('/')

    const title = "Big Data Indonesia";

    cy.get('[data-cy="input-search"]').type(title);
    cy.get(".suggestion-box").contains(title)
    cy.get('[data-cy="btn-search-submit"]').click();

    cy.contains(title);

    cy.url().should('eq', Cypress.config().baseUrl + "/home?title=Big+Data+Indonesia")
  })

  it('Cek perilaku sistem jika memasukkan judul tugas akhir yang tidak valid', () => {
    cy.visit('/')

    cy.get('[data-cy="input-search"]').type("judul tugas akhir");
    cy.get('[data-cy="btn-search-submit"]').click();

    cy.get('[data-cy="empty-message"]').contains('Dokumen Tidak Ditemukan');

    cy.location().should((loc) => {
      expect(loc.search).to.eq('?title=judul+tugas+akhir')
    })
    cy.url().should('eq', Cypress.config().baseUrl + "/home?title=judul+tugas+akhir")
  })
})