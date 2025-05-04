describe('Cek Fungsi Halaman Detail Dokumen', () => {
  it('Cek perilaku sistem jika menekan tab "Ringkasan"', () => {
    cy.visit('/home')

    cy.get(':nth-child(1) > .thesis-title-wrapper > .thesis-title').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/document')
    })

    cy.get('[data-cy="tab-overview"').click();
  })

  it('Cek perilaku sistem jika menekan tab "PDF"', () => {
    cy.logInStudent('farhan12', 'userpass')

    cy.visit('/home')

    cy.get(':nth-child(1) > .thesis-title-wrapper > .thesis-title').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/document')
    })

    cy.get('[data-cy="tab-pdf"]').click();
    cy.get('[data-cy="table-document-link"]').contains('No.');
    cy.get('[data-cy="table-document-link"]').contains('Dokumen');
    cy.get('[data-cy="table-document-link"]').contains('Keterangan');
  })

  it('Cek perilaku sistem jika menekan salah satu link dokumen', () => {
    cy.logInStudent('farhan12', 'userpass')

    cy.visit('/home')

    cy.get(':nth-child(1) > .thesis-title-wrapper > .thesis-title').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/document')
    })

    cy.get('[data-cy="tab-pdf"]').click();
    cy.get('[data-cy="table-document-link"]').contains('No.');
    cy.get('[data-cy="table-document-link"]').contains('Dokumen');
    cy.get('[data-cy="table-document-link"]').contains('Keterangan');

    cy.get(':nth-child(1) > :nth-child(2) > [data-cy="link-document"]').should('have.attr', 'target', 'blank');
    cy.get(':nth-child(1) > :nth-child(2) > [data-cy="link-document"]').click();
  })
})