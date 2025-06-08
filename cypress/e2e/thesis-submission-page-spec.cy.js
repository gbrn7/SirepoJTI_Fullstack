describe('Cek Fungsi Halaman Tugas Akhir', () => {
  it('Cek perilaku sistem jika mengunggah dokumen tugas akhir', () => {
    cy.logInStudent("farhan12", "userpass");

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-submission')
    })

    cy.get('[data-cy="btn-link-add-thesis"]').click();
    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-submission/create')
    })

    cy.get('[data-cy="input-title"]').type('test judul')
    cy.get('[data-cy="input-abstract"]').type('test abstract')
    cy.get('[data-cy="input-topic"]').select(1)
    cy.get('[data-cy="input-thesis-type"]').select(1)
    cy.get('[data-cy="input-lecturer"]').select(1)
    cy.get('[data-cy="input-complete-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-abstract-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-list-of-content-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-1-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-2-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-3-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-4-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-5-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-6-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-7-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-bibliography-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-attachment-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-submission')
    })

    cy.contains('Tugas Akhir Ditambahkan');
  })
})