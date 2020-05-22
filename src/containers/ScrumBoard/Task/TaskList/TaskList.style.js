import styled from 'styled-components';
import { grid } from '../../../../settings/constants';

export const Wrapper = styled.div`
  display: flex;
  flex-direction: column;
  opacity: ${({ isDropDisabled }) => (isDropDisabled ? 0.5 : 'inherit')};
  padding: 0 20px 20px;
  transition: background-color 0.1s ease, opacity 0.1s ease;
  user-select: none;
`;

export const DropZone = styled.div`
  min-height: 350px;
  margin-bottom: ${grid}px;
  > div {
    > div {
      > span[data-react-beautiful-dnd-drag-handle] {
        background-color: transparent;
        box-shadow: none !important;
      }
    }
  }
`;

export const ScrollContainer = styled.div`
  overflow-x: hidden;
  overflow-y: auto;
  max-height: calc(100vh - 180px);
`;
